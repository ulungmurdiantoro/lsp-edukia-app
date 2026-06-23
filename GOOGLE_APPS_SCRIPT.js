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

function doPost(e) {
  try {
    var data = JSON.parse(e.postData.contents);
    var values = data.values;

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
