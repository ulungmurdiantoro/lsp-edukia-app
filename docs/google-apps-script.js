/**
 * Google Apps Script — LSP Edukia Lamaran Karir Webhook
 *
 * SETUP (sekali saja):
 * 1. Buka Google Spreadsheet target
 * 2. Extensions → Apps Script
 * 3. Hapus semua kode yang ada, paste seluruh isi file ini
 * 4. Klik Deploy → New deployment
 *    - Type            : Web app
 *    - Execute as      : Me
 *    - Who has access  : Anyone
 * 5. Klik Deploy → copy URL yang muncul
 * 6. Isi di .env server:  GOOGLE_SHEETS_WEBHOOK_URL=<URL yang dicopy>
 * 7. Di server: php artisan config:cache
 *
 * OPSIONAL — token rahasia (supaya orang lain yang tahu URL tidak bisa menambah baris):
 *   a. Project Settings (ikon gerigi) → Script Properties → Add property:
 *        WEBHOOK_TOKEN = <token acak, mis. hasil: php -r "echo bin2hex(random_bytes(24));">
 *   b. Isi di .env server: GOOGLE_SHEETS_WEBHOOK_TOKEN=<token yang sama>, lalu config:cache
 *   Kalau WEBHOOK_TOKEN tidak diatur, token tidak dicek.
 *
 * Setelah mengubah kode ini: Deploy → Manage deployments → Edit → Version: New version
 * (URL tetap sama). Tanpa langkah itu, kode lama yang masih berjalan.
 */

var HEADERS = [
  'ID', 'Tanggal', 'Posisi', 'Nama Lengkap', 'TTL', 'WhatsApp',
  'Domisili', 'Pendidikan', 'Jurusan', 'Pengalaman Mutu',
  'Sertifikat ISO?', 'Daftar Sertifikat', 'Pengalaman Audit',
  'Full-time?', 'Status',
  'Link CV', 'Link Portofolio', 'Link Ijazah', 'Link Sertifikat Pelatihan'
];

function ensureHeader(sheet) {
  var firstCell = sheet.getRange(1, 1).getValue();

  // Jika baris pertama bukan header (kosong atau bukan 'ID'), tulis header
  if (firstCell !== 'ID') {
    sheet.insertRowBefore(1);
    sheet.getRange(1, 1, 1, HEADERS.length).setValues([HEADERS]);

    var headerRange = sheet.getRange(1, 1, 1, HEADERS.length);
    headerRange.setFontWeight('bold')
               .setBackground('#0a2547')
               .setFontColor('#ffffff')
               .setHorizontalAlignment('center');
    sheet.setFrozenRows(1);
  }
}

// Isian pelamar yang diawali = + - @ akan dieksekusi Sheets sebagai rumus (mis. IMPORTXML
// untuk mengirim data keluar). Awali dengan apostrof supaya selalu tersimpan sebagai teks.
function asText(value) {
  if (typeof value === 'string' && /^[=+\-@]/.test(value)) {
    return "'" + value;
  }
  return value;
}

function jsonOut(obj) {
  return ContentService
    .createTextOutput(JSON.stringify(obj))
    .setMimeType(ContentService.MimeType.JSON);
}

function doPost(e) {
  try {
    var data = JSON.parse(e.postData.contents);

    // Token opsional: bila WEBHOOK_TOKEN diatur di Script Properties, hanya permintaan dengan
    // token yang sama yang diterima. Bila tidak diatur, semua permintaan diterima.
    var expected = PropertiesService.getScriptProperties().getProperty('WEBHOOK_TOKEN');
    if (expected && data.token !== expected) {
      return jsonOut({ status: 'error', message: 'Token tidak valid.' });
    }

    var values = (data.values || []).map(asText);

    var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('Sheet1')
      || SpreadsheetApp.getActiveSpreadsheet().getSheets()[0];

    ensureHeader(sheet);

    sheet.appendRow(values);

    // Auto-resize kolom agar rapi
    sheet.autoResizeColumns(1, HEADERS.length);

    return ContentService
      .createTextOutput(JSON.stringify({ status: 'ok' }))
      .setMimeType(ContentService.MimeType.JSON);

  } catch (err) {
    return ContentService
      .createTextOutput(JSON.stringify({ status: 'error', message: err.message }))
      .setMimeType(ContentService.MimeType.JSON);
  }
}

// Untuk test manual dari Apps Script editor (Run → doGet)
function doGet(e) {
  return ContentService
    .createTextOutput('LSP Edukia Sheets Webhook aktif.')
    .setMimeType(ContentService.MimeType.TEXT);
}

// Jalankan manual dari editor untuk reset header + clear data lama
function resetSheet() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName('Sheet1')
    || SpreadsheetApp.getActiveSpreadsheet().getSheets()[0];

  sheet.clearContents();

  sheet.getRange(1, 1, 1, HEADERS.length).setValues([HEADERS]);

  var headerRange = sheet.getRange(1, 1, 1, HEADERS.length);
  headerRange.setFontWeight('bold')
             .setBackground('#0a2547')
             .setFontColor('#ffffff')
             .setHorizontalAlignment('center');
  sheet.setFrozenRows(1);
  sheet.autoResizeColumns(1, HEADERS.length);

  SpreadsheetApp.getUi().alert('Sheet berhasil direset. Silakan sync ulang data dari server.');
}
