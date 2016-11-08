# 3. kodutoo (II rühm)

## Kirjeldus
1. Lähtu ülesannete puhul alati oma ideest ning ole loominguline
  * AB'i kirjeid saab muuta ja kustutada (arhiveerida)
  * lehel töötab otsing ja tulemusi saab sorteerida 
  * abi saad tunnitöödest 

**OLULINE! ÄRA POSTITA GITHUBI GREENY MYSQL PAROOLE.** Selleks toimi järgmiselt:
  * loo eraldi fail `config.php`. Lisa sinna kasutaja ja parool ning tõsta see enda koduse töö kaustast ühe taseme võrra väljapoole
```PHP
  $serverHost = "localhost";
  $serverUsername = "username";
  $serverPassword = "password";
```
  * Andmebaasi nimi lisa aga kindlasti enda faili ja `require_once` käsuga küsi parool ja kasutajanimi `config.php` failist, siis saan kodust tööd lihtsamini kontrollida
```PHP
  // ühenduse loomiseks kasuta
  require_once("../config.php");
  $database = "database";
  $mysqli = new mysqli($servername, $username, $password, $database);
```
