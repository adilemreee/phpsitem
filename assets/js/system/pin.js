const mysql = require('mysql');
const schedule = require('node-schedule');

const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '',
  database: 'ezik2024'
});

connection.connect((err) => {
  if (err) {
    console.error('MySQL bağlantısı hatası: ' + err.stack);
    return;
  }

  console.log('MySQL bağlantısı başarıyla gerçekleştirildi.');
});

const job = schedule.scheduleJob('0 2 * * *', () => {
  const updateQuery = 'UPDATE accounts SET pin_claim = 3';

  connection.query(updateQuery, (err, results) => {
    if (err) {
      console.error('Veritabanı güncelleme hatası: ' + err.stack);
      return;
    }

    console.log('Veritabanı güncellendi. Güncellenen satır sayısı: ' + results.affectedRows);
  });
});

process.on('SIGINT', () => {
  connection.end((err) => {
    if (err) {
      return console.error('MySQL bağlantı kapatma hatası: ' + err.stack);
    }
    console.log('MySQL bağlantısı başarıyla kapatıldı.');
    process.exit();
  });
});
