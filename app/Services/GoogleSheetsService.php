<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Storage;

class GoogleSheetsService
{
    private Sheets $sheets;
    private string $spreadsheetId;

    public function __construct()
    {
        $credentialsPath = config('google-sheets.credentials_path');

        $client = new Client();
        $client->setApplicationName('LSP Edukia');
        $client->setScopes([Sheets::SPREADSHEETS]);
        $client->setAuthConfig($credentialsPath);

        $this->sheets        = new Sheets($client);
        $this->spreadsheetId = config('google-sheets.spreadsheet_id');
    }

    /**
     * Tambahkan satu baris ke sheet pertama spreadsheet.
     */
    public function appendRow(array $values): void
    {
        $body = new \Google\Service\Sheets\ValueRange(['values' => [$values]]);

        $this->sheets->spreadsheets_values->append(
            $this->spreadsheetId,
            'Sheet1!A1',
            $body,
            ['valueInputOption' => 'RAW', 'insertDataOption' => 'INSERT_ROWS']
        );
    }

    /**
     * Pastikan baris header ada di baris pertama spreadsheet.
     * Dipanggil sekali saat row pertama masuk.
     */
    public function ensureHeader(array $headers): void
    {
        $response = $this->sheets->spreadsheets_values->get(
            $this->spreadsheetId,
            'Sheet1!A1:A1'
        );

        $existing = $response->getValues();

        if (empty($existing)) {
            $body = new \Google\Service\Sheets\ValueRange(['values' => [$headers]]);
            $this->sheets->spreadsheets_values->update(
                $this->spreadsheetId,
                'Sheet1!A1',
                $body,
                ['valueInputOption' => 'RAW']
            );
        }
    }
}
