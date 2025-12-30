import os
import subprocess
import schedule
import time
from datetime import datetime

# MySQL bağlantı bilgileri
host = "YOUR_HOST"
user = "YOUR_USER"
password = "YOUR_PASSWORD"
database = "YOUR_DATABASE"

# Dosya kaydetme konumu
save_location = r"YOUR_BACKUP_PATH"

def backup_database():
    try:
        backup_time = datetime.now().strftime('%Y%m%d_%H%M%S')
        backup_filename = f"backup_{backup_time}.sql"
        backup_path = os.path.join(save_location, backup_filename)

        # mysqldump komutunu kullanarak veritabanını yedekle
        # mysqldump'ın doğru yolu ile değiştirin
        mysqldump_path = r"YOUR_MYSQLDUMP_PATH" 
        subprocess.run([mysqldump_path, "-h", host, "-u", user, f"--password={password}", database, "--result-file", backup_path])

        print(f"Veritabanı başarıyla yedeklendi: {backup_filename}")

    except Exception as e:
        print(f"Hata oluştu: {e}")

# 24 saatte bir yedekleme işlemini başlat
schedule.every(1440).minutes.do(backup_database)

while True:
    schedule.run_pending()
    time.sleep(1)
