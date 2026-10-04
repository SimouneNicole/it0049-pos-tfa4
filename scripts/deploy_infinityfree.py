#!/usr/bin/env python3
"""
Automated FTP Deployment for IT0049 POS TFA4 to InfinityFree.
Uploads the contents of dist/infinityfree_tfa4/ to /htdocs on ftpupload.net.
"""

import ftplib
import os
import sys
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent
BUILD_DIR = BASE_DIR / "dist" / "infinityfree_tfa4"

def load_credentials():
    env_file = BASE_DIR / ".env.infinityfree"
    creds = {
        "FTP_HOST": os.getenv("FTP_HOST", "ftpupload.net"),
        "FTP_PORT": int(os.getenv("FTP_PORT", "21")),
        "FTP_USER": os.getenv("FTP_USER", ""),
        "FTP_PASS": os.getenv("FTP_PASS", ""),
    }
    if env_file.exists():
        for line in env_file.read_text().splitlines():
            line = line.strip()
            if line.startswith("database.default.username"):
                creds["FTP_USER"] = creds["FTP_USER"] or line.split("=")[1].strip().strip("'\"")
            elif line.startswith("database.default.password"):
                creds["FTP_PASS"] = creds["FTP_PASS"] or line.split("=")[1].strip().strip("'\"")
    return creds

REMOTE_HTDOCS = "htdocs"

def connect_ftp():
    creds = load_credentials()
    host = creds["FTP_HOST"]
    port = creds["FTP_PORT"]
    user = creds["FTP_USER"]
    password = creds["FTP_PASS"]
    print(f"Connecting to FTP {host}:{port} as {user} ...")
    ftp = ftplib.FTP(timeout=30)
    ftp.connect(host, port)
    ftp.login(user, password)
    print("✓ FTP connected and authenticated.")
    return ftp

def remove_default_index2(ftp):
    try:
        current_files = ftp.nlst()
        if "index2.html" in current_files:
            ftp.delete("index2.html")
            print("✓ Removed default hosting placeholder 'index2.html'.")
    except Exception as e:
        print(f"Note regarding placeholder check: {e}")

def upload_directory(ftp, local_dir: Path, remote_path: str):
    for entry in local_dir.iterdir():
        rel_path = entry.relative_to(local_dir).as_posix()
        target_remote = f"{remote_path}/{rel_path}" if remote_path else rel_path

        if entry.is_dir():
            try:
                ftp.mkd(rel_path)
            except ftplib.error_perm:
                # Directory already exists
                pass
            ftp.cwd(rel_path)
            upload_directory(ftp, entry, target_remote)
            ftp.cwd("..")
        else:
            with open(entry, "rb") as f:
                ftp.storbinary(f"STOR {rel_path}", f)
            print(f"Uploaded: {target_remote}")

def main():
    if not BUILD_DIR.exists():
        print("Build directory does not exist! Running package_infinityfree.py first...")
        from package_infinityfree import prepare_dist, copy_application_files, create_zip
        prepare_dist()
        copy_application_files()
        create_zip()

    ftp = connect_ftp()
    try:
        ftp.cwd(REMOTE_HTDOCS)
        print(f"✓ Changed remote working directory to /{REMOTE_HTDOCS}")
        remove_default_index2(ftp)

        print("\nStarting upload to /htdocs ...")
        upload_directory(ftp, BUILD_DIR, "")
        print("\n✓ Deployment upload completed successfully!")
    finally:
        try:
            ftp.quit()
        except Exception:
            pass

if __name__ == "__main__":
    main()
