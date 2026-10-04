#!/usr/bin/env python3
"""
Package IT0049 POS TFA4 for InfinityFree Shared Hosting.
Produces:
  1. dist/infinityfree_tfa4/  (clean directory ready for upload into /htdocs)
  2. dist/it0049-pos-tfa4-infinityfree.zip (ZIP archive for manual upload or backup)
"""

import os
import shutil
import zipfile
from pathlib import Path

BASE_DIR = Path(__file__).resolve().parent.parent
DIST_DIR = BASE_DIR / "dist"
BUILD_DIR = DIST_DIR / "infinityfree_tfa4"
ZIP_PATH = DIST_DIR / "it0049-pos-tfa4-infinityfree.zip"

def prepare_dist():
    if DIST_DIR.exists():
        shutil.rmtree(DIST_DIR)
    BUILD_DIR.mkdir(parents=True, exist_ok=True)
    print(f"Created build directory: {BUILD_DIR}")

def copy_application_files():
    # 1. Copy app/
    shutil.copytree(BASE_DIR / "app", BUILD_DIR / "app")
    print("✓ Copied app/")

    # 2. Copy vendor/
    if not (BASE_DIR / "vendor").exists():
        raise RuntimeError("vendor/ directory missing. Run 'composer install --no-dev' first.")
    shutil.copytree(BASE_DIR / "vendor", BUILD_DIR / "vendor")
    print("✓ Copied vendor/")

    # 3. Create fresh writable/
    writable_dir = BUILD_DIR / "writable"
    writable_dir.mkdir(parents=True, exist_ok=True)
    for sub in ["cache", "debugbar", "logs", "session", "uploads"]:
        sub_path = writable_dir / sub
        sub_path.mkdir(parents=True, exist_ok=True)
        # Put empty index.html
        (sub_path / "index.html").write_text("<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>\n")
    # writable/.htaccess
    (writable_dir / ".htaccess").write_text("<IfModule authz_core_module>\n    Require all denied\n</IfModule>\n<IfModule !authz_core_module>\n    Deny from all\n</IfModule>\n")
    (writable_dir / "index.html").write_text("<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>\n")
    print("✓ Created fresh writable/ directory")

    # 4. Copy public assets directly into web root
    public_dir = BASE_DIR / "public"
    for item in ["css", "images", "uploads"]:
        src = public_dir / item
        if src.exists():
            shutil.copytree(src, BUILD_DIR / item)
    for file_name in ["favicon.ico", "robots.txt"]:
        src = public_dir / file_name
        if src.exists():
            shutil.copy2(src, BUILD_DIR / file_name)
    print("✓ Copied public assets (css, images, uploads, favicon.ico, robots.txt)")

    # 5. Copy InfinityFree specific .htaccess & index.php
    shutil.copy2(BASE_DIR / "package_infinityfree" / ".htaccess", BUILD_DIR / ".htaccess")
    shutil.copy2(BASE_DIR / "package_infinityfree" / "index.php", BUILD_DIR / "index.php")
    if (BASE_DIR / "package_infinityfree" / "extract.php").exists():
        shutil.copy2(BASE_DIR / "package_infinityfree" / "extract.php", BUILD_DIR / "extract.php")
    print("✓ Injected front controller index.php, hardened .htaccess, and extract.php")

    # 6. Copy production .env
    shutil.copy2(BASE_DIR / ".env.infinityfree", BUILD_DIR / ".env")
    print("✓ Injected production .env with InfinityFree database credentials")

    # 7. Copy sanitized database SQL for reference
    db_export_dest = BUILD_DIR / "db_export"
    db_export_dest.mkdir(parents=True, exist_ok=True)
    shutil.copy2(BASE_DIR / "db_export" / "infinityfree_database.sql", db_export_dest / "infinityfree_database.sql")
    print("✓ Included db_export/infinityfree_database.sql")

def create_zip():
    print(f"Creating ZIP archive: {ZIP_PATH} ...")
    with zipfile.ZipFile(ZIP_PATH, "w", zipfile.ZIP_DEFLATED) as zip_out:
        for root, dirs, files in os.walk(BUILD_DIR):
            for file in files:
                full_path = Path(root) / file
                rel_path = full_path.relative_to(BUILD_DIR)
                zip_out.write(full_path, rel_path)
    zip_size_mb = ZIP_PATH.stat().st_size / (1024 * 1024)
    print(f"✓ ZIP package ready: {ZIP_PATH} ({zip_size_mb:.2f} MB)")

if __name__ == "__main__":
    prepare_dist()
    copy_application_files()
    create_zip()
    print("\nPackage generation complete!")
