<?php
class DataProvider {
    private string $filePath;

    public function __construct(string $filePath) {
        $this->filePath = $filePath;
    }

    public function getData(): array {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true) ?? [];
    }
}

header('Content-Type: application/json');
$dataProvider = new DataProvider('data.json');
echo json_encode($dataProvider->getData());
