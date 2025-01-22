<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Tek Sorumluluk Prensibi - Veri Listesi</title>
    <style>
        body { font-family: Arial, sans-serif; }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>JSON Veri Listesi</h1>
    <ul id="data-list"></ul>

    <script>
        fetch('data_provider.php')
            .then(response => response.json())
            .then(data => {
                const listElement = document.getElementById('data-list');
                data.forEach(item => {
                    const listItem = document.createElement('li');
                    listItem.textContent = `${item.name} - ${item.description}`;
                    listElement.appendChild(listItem);
                });
            })
            .catch(error => {
                const errorMessage = document.createElement('p');
                errorMessage.textContent = 'Veri yüklenemedi.';
                document.body.appendChild(errorMessage);
            });
    </script>
</body>
</html>
