<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envoi de message WhatsApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
<div class="bg-white p-6 rounded-lg shadow-md w-96">
    <h2 class="text-xl font-semibold mb-4 text-center">Envoyer un message WhatsApp</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('send') }}" method="POST">
        @csrf
        <label class="block mb-2 font-medium">Numéro WhatsApp (format international)</label>
        <input type="text" name="phone" class="w-full p-2 border rounded mb-4" placeholder="Ex: 22990830108" required>

        <label class="block mb-2 font-medium">Nom du template</label>
        <textarea name="templateName" class="w-full p-2 border rounded mb-4" placeholder="Tapez votre nom de template ici..." required></textarea>

        <label class="block mb-2 font-medium">Langue du template</label>
        <textarea name="templateLanguage" class="w-full p-2 border rounded mb-4" placeholder="Tapez votre langue de template ici..." required></textarea>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Envoyer</button>
    </form>
</div>
</body>
</html>
