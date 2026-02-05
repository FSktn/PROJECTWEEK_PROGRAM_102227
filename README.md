# ESA Ruimte Object Upload Systeem

Een webapplicatie voor het uploaden en beheren van ruimte-objecten foto's voor de European Space Agency (ESA).

## Bestanden

- `index.php` - Upload formulier voor ruimte objecten
- `galerij.php` - Overzichtspagina met alle geüploade ruimte objecten
- `verwerk.php` - Verwerkt uploads en slaat gegevens op in de database
- `config.php` - Database configuratie en PDO connectie
- `database.sql` - SQL schema voor de database tabel
- `kosmos/` - Map waar geüploade afbeeldingen worden opgeslagen

## Installatie

1. Importeer `database.sql` in je MySQL database
2. Pas de database gegevens aan in `config.php` indien nodig
3. Zorg dat de `kosmos/` map schrijfrechten heeft (wordt automatisch aangemaakt)
4. Open `index.php` in je browser

## Database Configuratie

Standaard instellingen in `config.php`:
- Host: localhost
- Database: esa_space_objects
- Gebruiker: root
- Wachtwoord: (leeg)

## Functionaliteiten

- Upload formulier met validatie
- Controleert of bestand een afbeelding is (JPEG, PNG, GIF, WebP)
- Controleert bestandsgrootte (maximum 5MB)
- Slaat afbeeldingen op in de kosmos map met unieke bestandsnamen
- Slaat metadata op in database met PDO
- Gegevens worden alleen opgeslagen als upload succesvol is
- Galerij pagina om alle geüploade ruimte objecten te bekijken
- Eenvoudige en overzichtelijke styling

## Vereisten

- PHP 7.0 of hoger
- MySQL database
- PDO extensie ingeschakeld
