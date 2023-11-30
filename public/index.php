<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            background-color: #f0f0f0;
            margin: 0;
        }

        .navbar {
            background-color: #363636;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        .navbar a {
            color: #f2f2f2;
            text-decoration: none;
            margin: 0 15px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
        }

        .search-bar input[type="text"] {
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
            padding: 10px;
            font-size: 16px;
            width: 60%;
        }

        .search-bar select {
            border: none;
            border-radius: 0;
            font-size: 16px;
            margin-left: -1px;
            padding-bottom: 11px;
            padding-right: +2px;
            box-sizing: border-box;
        }

        .search-bar button {
            background-color: #FF69B4;
            border: none;
            border-radius: 0 4px 4px 0;
            color: white;
            cursor: pointer;
            padding: 9px;
            padding-bottom: 12px;
        }

        .search-bar button i {
            font-size: 18px;
        }

        .logo-img {
            display: block;
            width: 130px;
        }

        .image-feed-container {
            margin-top: 20px;
            padding: 20px;
        }

        .filter-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            text-align: center;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        select {
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            padding: 10px;
        }

        select:focus {
            outline: none;
        }

        .filter-select{
            text-align: center;
            padding: 0px;
        }

        .image-feed {
            align-content: flex-start;
            display: flex;
            flex-wrap: wrap;
            gap: 0px;
        }

        .image-card {
            align-self: flex-start;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            max-width: 250px;
            overflow: hidden;
            position: relative;
        }

        .image-card img {
            width: 100%;
        }

        .tags {
            background-color: #FF69B4;
            color: white;
            padding: 10px;
            text-align: center;
        }

        .upload-button,
        .upload-button-nav {
            background-color: #FF69B4;
            border: none;
            border-radius: 50%;
            color: white;
            cursor: pointer;
            font-size: 18px;
            padding: 10px;
            position: fixed;
            right: 20px;
            bottom: 20px;
        }

        .upload-button-nav {
            border-radius: 50%;
        }

        .modal {
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            height: 100%;
            justify-content: center;
            left: 0;
            position: fixed;
            top: 0;
            width: 100%;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 8px;
            margin: 0 auto;
            max-width: 400px;
            padding: 20px;
            position: relative;
            text-align: center;
            width: 80%;
        }

        .close-button {
            cursor: pointer;
            position: absolute;
            right: 15%;
            top: 10%;
        }

        #imagePreview {
            display: none;
            height: auto;
            margin-bottom: 10px;
            max-width: 100%;
        }

        form {
            align-items: center;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            margin: 0 auto;
            max-width: 300px;
            padding: 20px;
        }

        .form-label {
            color: #555;
            font-size: 16px;
            margin-top: 10px;
        }

        .form-input {
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            margin-top: 5px;
            padding: 10px;
            width: 100%;
        }

        .form-input::placeholder {
            color: #999;
        }

        .form-input:focus {
            border-color: #FF69B4;
        }

        .form-button {
            background-color: #FF69B4;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
            padding: 12px;
            transition: background-color 0.3s ease;
        }

        .form-button:hover {
            background-color: #E6408B;
        }

        @media screen and (max-width: 1200px) {
            .image-feed {
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        @media screen and (max-width: 1000px) {
            .image-feed {
                align-items: center;
                justify-content: center;
            }
        }

        @media screen and (max-width: 600px) {
            .navbar {
                align-items: center;
                flex-direction: column;
            }

            .search-bar input[type="text"],
            .search-bar select,
            .search-bar button {
                margin: 5px 0;
            }
            .search-bar button {
                padding: 11px 12px;
                padding-bottom: 10px;
            }

            .navbar a {
                margin: 10px 0;
            }

            .logo-img {
                display: none;
            }

            .image-card {
                max-width: none;
            }

            .upload-button {
                display: block;
            }

            .upload-button-nav {
                display: none;
            }

            .image-feed {
                align-items: center;
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
    <title>Retro Navbar</title>
</head>

<body>

    <div class="navbar">
        <a href=".">
            <img class="logo-img" src="/public/images/host/logo.png" alt="Logo">
        </a>

        <div class="search-bar">
            <input type="text" placeholder="Search">
            <select>
                <option value="image">Image</option>
                <option value="gif">GIF</option>
            </select>
            <button type="button"><i class="fas fa-search"></i></button>
        </div>
        <button class="upload-button-nav" onclick="openModal()"><i class="fas fa-upload"></i></button>
    </div>

    <div class="image-feed-container">
        <div class="filter-section">
            <h1>🔥 Em alta!</h1>
            <select class="filter-select">
                <option value="recent">Recent</option>
                <option value="oldposts">Old Posts</option>
                <option value="mostvisited">Most Visited</option>
                <option value="leastvisited">Least Visited</option>
                <option value="hottest">Hottest</option>
                <option value="lesshot">Less hot</option>
            </select>
        </div>

        <div class="image-feed">
            <!-- Exemplo de card de imagem -->
            <div class="image-card">
                <img src="public/images/uploads/1.jpg" alt="Imagem">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/2.jpg" alt="Imagem 16:9">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/3.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/4.jpeg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/5.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/6.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/7.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/3.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/4.jpeg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/5.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/6.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/5.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/6.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/7.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/3.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/4.jpeg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/5.jpg" alt="Imagem 3:4">
            </div>
            <div class="image-card">
                <img src="public/images/uploads/6.jpg" alt="Imagem 3:4">
            </div>
        </div>
    </div>

    <button class="upload-button" onclick="openModal()"><i class="fas fa-upload"></i></button>
    
    <div class="modal" id="uploadModal">
        <div class="modal-content">
            <form id="uploadForm">
                <h2>Upload de Imagem</h2>
                <label for="imageName" class="form-label">Nome:</label>
                <input type="text" id="imageName" name="imageName" class="form-input" placeholder="Digite o nome" required>

                <label for="imageCategory" class="form-label">Categoria:</label>
                <input type="text" id="imageCategory" name="imageCategory" class="form-input" placeholder="Digite a categoria" required>

                <label for="imageFile" class="form-label">Escolha uma imagem:</label>
                <input type="file" id="imageFile" name="imageFile" accept="image/*" class="form-input" required>

                <img id="imagePreview" src="#" alt="Preview da imagem" style="display: none;">

                <button type="button" onclick="uploadImage()" class="form-button">Enviar</button>

                <span class="close-button" onclick="closeModal()">&times;</span>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            var modal = document.getElementById('uploadModal');
            modal.style.display = 'flex';

            // Oculta a prévia da imagem ao abrir a janela modal
            document.getElementById('imagePreview').style.display = 'none';
        }

        function closeModal() {
            var modal = document.getElementById('uploadModal');
            modal.style.display = 'none';

            // Limpa a prévia da imagem ao fechar a janela
            document.getElementById('imagePreview').src = '';
            document.getElementById('imagePreview').style.display = 'none';

            // Reinicializa o formulário para limpar o campo de arquivo
            document.getElementById('uploadForm').reset();
        }

        function previewImage() {
            var fileInput = document.getElementById('imageFile');
            var imagePreview = document.getElementById('imagePreview');

            fileInput.addEventListener('change', function () {
                var file = fileInput.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    // Exibe a prévia da imagem e define o src
                    imagePreview.style.display = 'block';
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(file);
            });
        }

        function uploadImage() {
            // Adicione aqui a lógica para processar o upload da imagem
            // Você pode usar o FormData e fazer uma requisição AJAX, por exemplo
            alert('Imagem enviada com sucesso!');
            closeModal();
        }

        document.addEventListener('DOMContentLoaded', function () {
            previewImage();
        });

        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth > 540) {
                // Somente inicialize o Masonry.js para telas maiores que 600px
                var grid = document.querySelector('.image-feed');
                var masonry = new Masonry(grid, {
                    itemSelector: '.image-card',
                    columnWidth: 50,
                    gutter: 15,
                    fitWidth: true
                });
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/masonry/4.2.2/masonry.pkgd.min.js"></script>

</body>

</html>
