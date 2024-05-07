# FSU23D-Systemutveckling-Uppgift-2

Bygg en SaaS-tjänst för att kunder ska kunna hantera sina epost-listor. Vi kommer ha 2 roller av användare, kunder och prenumeranter, där en kund kan se en lista med uppgifter prenumeranter som har valt att prenumerera på deras nyhetsbrev.

## Kraven för denna uppgift:

### Betyg G

 

- Databasen ska vara MySQL (eller Mariadb).
- Alla sidor ska vara skrivna i php (ingen react mot api tillåten för denna uppgift).
- Ett användarkonto ska lagra namn (för- och efternamn), epostadress och hash för lösenord.
- Ett kundkonto ska ha information om nyhetsbrevet: namn och beskrivning
- En prenumerant ska enkelt kunna börja prenumerera och sluta prenumerera på ett nyhetsbrev
- Fungerande inloggning och återställning av lösenord, med epostutskick.
- Epost ska skickas med en Email service provider (ESP)

 

- Dessa sidor ska finnas:

  - Skapa konto (välj typ: kund eller prenumerant)

  - Lista alla nyhetsbrev

    - Enskilt nyhetsbrev (prenumerera / avregistrera)

  - Logga in

    - Återställ lösenord

      - Ange nytt lösenord

    - Utloggad (Endast: meddelande om att man är utloggad)

  - Mina sidor (Endast: välkomstmeddelande efter inloggning)

    - Mina prenumerationer (för prenumeranter)

    - Mina prenumeranter (för kunder)

    - Mitt nyhetsbrev / Redigera nyhetsbrev (för kunder)

- Menyn på sidan ska vara annorlunda baserat på om du är kund eller prenumerant

  - Meny för utloggad: Alla nyhetsbrev, Logga in, Skapa konto

  - Meny för prenumerant: Alla nyhetsbrev, Mina prenumerationer, Logga ut

  - Meny för kunder:  Mina prenumeranter, Mitt nyhetsbrev, Logga ut

- Om man försöker visa en sida som man inte har tillgång till (baserat på användarroll) ska det visas ett meddelande om att man inte får det. Alternativt göra en redirect till en sida med samma information

 

### Betyg VG:

- En användare ska kunna vara både kund och prenumerant på samma gång.
- Ett användarkonto ska ha ett personligt salt-värde som används i hash-funktionen för lösenordet
- Inloggade sessioner ska finnas med i databasen
- En användare ska kunna logga ut från alla sina sessioner med ett knapptryck
- “Ange nytt lösenord” måste vara en “hot link” som endast är giltig 20 minuter.
- Alla sidor ska vara byggda med ett mvc-ramverk (Codeignitor är föreslaget, men andra går bra om man vill)

## Denna uppgift mäter följande moment från kursplanen:

- programstruktur för hantering av information, informationsflödeoch användare
- designa system och kodbaser utifrån arkitektuella principer
- använda Postman för att testa API:er

## Denna uppgift mäter följande VG-moment från kursplanen:

- Implementera MVC-ramverk
