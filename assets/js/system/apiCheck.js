const axios = require('axios');
const fs = require('fs');
const path = require('path');

const apiUrls = [ //status değerlerini almak istediğiniz apileri giriniz
    '',
    ''
];

const dosyaYolu = path.join(__dirname, '../../../pages/json', 'api.json');

const api = async () => {
    const combinedData = [];

    for (const apiUrl of apiUrls) {
        try {
            const response = await axios.get(apiUrl);
            const status = response.data.Status;
            const apiName = `apiname${apiUrls.indexOf(apiUrl) + 1}`;
            const jsonData = { ApiName: apiName, Status: status };
            combinedData.push(jsonData);
            console.log(`${apiName} API'nin Status değeri alındı.`);
        } catch (error) {
            console.error(`Hata (${apiUrl}):`, error.message);
        }
    }

    // JSON dosyasına yazma işlemi
    fs.writeFileSync(dosyaYolu, JSON.stringify(combinedData, null, 2));
    console.log(`Tüm API'lerin Status değerleri ${dosyaYolu} dosyasına yazıldı.`);
};

const periyot = 30 * 60 * 1000;
setInterval(api, periyot);

api();
