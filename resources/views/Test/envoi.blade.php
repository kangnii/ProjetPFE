<form action="{{route('')}}" method="post">

    @csrf

    <label for="number">Phone</label>
    <input type="text" name="number" id="number" placeholder="format:229..."><br><br>



    <label for="templateName">Nom du template</label>
    <input type="text" name="templateName" id="templateName"><br><br>

    <label for="templateLanguage">Langue du template</label>
    <input type="text" name="templateLanguage" id="templateLanguage"><br><br>

    <button type="submit">Envoyer échéance</button>

</form>
