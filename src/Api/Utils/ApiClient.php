<?php
/*
 * ApiClient.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi\Api\Utils;

use Illuminate\Support\Str;
use Illuminate\Validation\UnauthorizedException;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class ApiClient
{
    protected $client;
    protected $baseUrl;
    protected $apiToken;

    public function __construct()
    {
        $this->baseUrl = config('heizreport-api.base_url', 'https://heizreport.de/api/');
        $this->apiToken = config('heizreport-api.api_token');
        $this->client = $client ?? new Client(['base_uri' => $this->baseUrl]);
    }

    private function getClient(): Client
    {
        return $this->client;
    }

    private function getToken(): string
    {
        return $this->apiToken;
    }

    public function execute(string $httpMethod, string $endpoint = '', array $parameters = [])
    {
        try {
            $headers = [
                'Accept' => 'application/json'
            ];
            // Standardparameter (z.B. API-Token und Version) zu den übergebenen Parametern hinzufügen
            $parameters = array_merge([
                'version' => 1,
                'apikey' => $this->getToken(),
            ], $parameters);

            // Anfrage ausführen
            $response = $this->getClient()->{$httpMethod}($endpoint, [
                'headers' => $headers,
                'json' => $parameters
            ]);

            return $this->handleResponse($response);
        } catch (BadResponseException $exception) {
            $this->handleException($exception);
        }

    }

    // ========================= Response methods ======================================

    private function handleResponse($response): array
    {
        $responseBody = json_decode((string)$response->getBody(), true);

        if (isset($responseBody['error'])) {
            throw new \Exception($responseBody['message'] ?? 'Unknown error');
        }
        if (isset($responseBody['status']) && $responseBody['status'] == 400) {
            throw new UnauthorizedException($responseBody['message'] ?? 'Unauthorized');
        }

        return $responseBody;
    }

    private function handleException($exception): void
    {
        $response = json_decode((string)$exception->getResponse()->getBody(), true);

        if (isset($response['error'])) {
            throw new \Exception($response['message'] ?? 'Unknown error');
        }
        if (isset($response['status']) && $response['status'] == 400) {
            throw new UnauthorizedException($response['message'] ?? 'Unauthorized');
        }

        throw new \Exception('Something went wrong.');
    }

    // ========================= base methods ======================================

    public function _get($url = null, $parameters = [])
    {
        return $this->execute('get', $url, $parameters);
    }

    public function _post($url = null, array $parameters = [])
    {
        return $this->execute('post', $url, $parameters);
    }

    public function _put($url = null, array $parameters = [])
    {
        return $this->execute('put', $url, $parameters);
    }

    public function _patch($url = null, array $parameters = [])
    {
        return $this->execute('patch', $url, $parameters);
    }

    public function _delete($url = null, array $parameters = [])
    {
        return $this->execute('delete', $url, $parameters);
    }

    /**
     * Get the PDF file from the given path.
     *
     * @param string $path
     * @param string $filename
     * @param string $operation
     * @return string|null
     */
    protected function getPdf(string $path, $filename, $operation = 'download')
    {
        $response = $this->getClient()->get($path, [
            'headers' => [
                'Accept' => 'application/pdf',
            ]
        ]);

        $content = (string) $response->getBody();

         // Handle the operation based on the 'operation' parameter
        if ($operation === 'download') {
            // Send the PDF file to the browser for download
            $this->downloadPdf($content, $filename);
        } elseif ($operation === 'save') {
            // Save the PDF to the server and return the saved file path
            return $this->savePdf($content);
        }
        return null;
    }

    /**
     * Serve the PDF file as a download.
     *
     * @param string $content
     * @param string $filename
     */
    protected function downloadPdf(string $content, string $filename): void
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . strlen($content));

        echo $content;
        exit();
    }

    /**
     * Save the PDF file to the server.
     *
     * @param string $content
     * @return string
     */
    protected function savePdf(string $content): string
    {
        // Define the default directory to store the PDF file
        $directory = 'public/heizreports'; // Use the passed directory or fallback to default
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true); // Create the directory if it doesn't exist
        }
         // Erzeuge einen zufälligen Dateinamen mit der Endung '.pdf'
        $filename = Str::random(40) . '.pdf'; // 40 Zeichen lange zufällige Zeichenkette
        $filepath = $directory . '/' . $filename;
         // Store the file using Laravel's storage functionality
        Storage::put($filepath, $content);

        // Return the stored file path
        return $filepath;
    }
}
