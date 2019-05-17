<!DOCTYPE html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="script.js"></script>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div id="container">
<form id="sviatky" method="GET">
    <h5>Vyber štát pre výpis sviatkov </h5>
    <select name="stat" id="stat">
        <option value="SK">SK</option>
        <option value="CZ">CZ</option>
    </select>
    <input type="submit" value="odoslat">
</form>

<form id="meniny" method="GET">
    <h5>Vyber štát a zadaj dátum </h5>
    <select name="statik" id="statik">
        <option value="SK">SK</option>
        <option value="CZ">CZ</option>
        <option value="HU">HU</option>
        <option value="AT">AT</option>
        <option value="PL">PL</option>
    </select>
    <input id=datum type="text" placeholder="Zadaj datum">
    <input type="submit" value="odoslat">
</form>

<form id="date" method="GET">
    <h5>Vyber štát a zadaj meno </h5>
    <select name="krajina" id="krajina">
        <option value="SK">SK</option>
        <option value="CZ">CZ</option>
        <option value="HU">HU</option>
        <option value="AT">AT</option>
        <option value="PL">PL</option>
    </select>
    <input id=meno type="text" placeholder="Zadaj meno">
    <input type="submit" value="odoslat">
</form>

<form id="pam" method="GET">
    <h5>Výber </h5>
    <select name="country" id="country">
        <option value="SK">Pamätné dni SK</option>
    </select>
    <input type="submit" value="odoslat">
</form>
<form id="vloz" method="POST">
    <h5>Vyber štát a zadaj dátum a meno ktoré chceš pridať </h5>
    <select name="stat" id="staty">
        <option value="SK">SK</option>
    </select>
    <input id="datumm" name="datumm" type="text" placeholder="Zadaj datum">
    <input id="menov" name="menov" type="text" placeholder="Zadaj meno">
    <input type="submit" value="vloziť">
</form>
</div>
<div id="myDiv"></div>
<div >
<h3>Dokumentácia API</h3>
    <h4>Sviatky v zadanom štáte</h4>
    <p>Metóda: GET <br>URL: http://147.175.121.210:8126/cviko1/cviko6/index.php/sviatky/SK</p>
    <p>Formulár umožnuje získať štátne sviatky z dvoch krajin a to SK a CZ <br>výsledkom je dátum vo formate dd.mm. a názov sviatku <br> príklad : 01.01. Deň vzniku Slovenskej republiky</br></p>
    <h4>Meniny</h4>
    <p>Metóda: GET <br>URL: http://147.175.121.210:8126/cviko1/cviko6/index.php/stat/SK/den/0102</p>
    <p>Formulár umožnuje získať meno prípadne mená ktoré má v daný deň slavia meniny v jednom zo zvolených štátov SK,CZ,HU,PL,AT <br></p>
    <h4>Dátum</h4>
    <p>Metóda: GET <br>URL: http://147.175.121.210:8126/cviko1/cviko6/index.php/stat/SK/meno/Jakub</p>
    <p>Formulár umožnuje získať dátum kedy slávi zadané meno meniny v jednom z týchto štátov SK,CZ,HU,PL,AT </p>
    <h4>Slovenské pamätné dni</h4>
    <p>Metóda: GET <br>URL: http://147.175.121.210:8126/cviko1/cviko6/index.php/pamdni/SK</p>
    <p>Formulár umožnuje získať všetky pamätné dni Slovenskej republiky </p>
    <p>Dátum je vo formáte dd.mm. a názov daného pamätného dňa</p>
    <h4>Vloženie mena do kalendára</h4>
    <p>Metóda: POST <br>URL: http://147.175.121.210:8126/cviko1/cviko6/index.php/stat/SK/den/0102/meno/</p>
    <p>Formulár umožnuje vložiť meno do kalendára slovenských mien, po zadaní dátumu a mena</p>
</div>

</body>
</html>