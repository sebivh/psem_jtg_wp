![Jüdisch to Go Logo](./assets/pictures/JTGLogo.svg)

# Dokumentation der Wartung der Jüdisch to go Website
_Autor:_ Sebastian von Helmersen | [sebivhelm@hotmail.com](mailto:sebivhelm@hotmail.com)


## Struktur:
- [Dokumentation der Wartung der Jüdisch to go Website](#dokumentation-der-wartung-der-jüdisch-to-go-website)
  - [Struktur:](#struktur)
  - [Einleitung](#einleitung)
  - [Hosting](#hosting)
    - [Zugangsdaten](#zugangsdaten)
    - [Domain](#domain)
    - [SSL](#ssl)
    - [Mailboxen](#mailboxen)
    - [FTP Accounts](#ftp-accounts)
    - [PHP Version/Serverspezifische Konfiguration](#php-versionserverspezifische-konfiguration)
  - [Website](#website)
    - [Zugangsdaten](#zugangsdaten-1)
    - [Custom Theme: jtg WordPress Theme](#custom-theme-jtg-wordpress-theme)
      - [Orte](#orte)
      - [Design Customizor](#design-customizor)
    - [Plugins](#plugins)
    - [Shortcodes](#shortcodes)
    - [QR-Codes / Tafeln](#qr-codes--tafeln)

## Einleitung
Das folgende Dokument dient als Nachschlagewerk für die Bedienung und Wartung der Jüdisch To Go Website. Zielsetzung ist es selbst einem Laien die Wartung zu ermöglichen. Es ist allerdings darauf hinzuweisen das ein tieferes Verständnis der verwendeten Technologien nötig ist um evtl. auftretende Fehler zu beheben.  
Die Dokumentation ist aufgeteilt in zwei große Abschnitte. Diese Aufteilung dient dazu die semantische Lücke zwischen Webserver und Website darzustellen. Diese können auch ohne großes Wissen voneinander individuell gewartet werden.
## Hosting
Der Hostinganbieter der Website ist Hetzner. Speziell in diesem Kapitel empfiehlt es sich für Laien sich an die dokumentieren Einstellungen halten und keine Änderungen vorzunehmen. Selbst kleinere Änderungen können zu Problemen führen, deren Behebung dann nur durch einen Fachmann möglich ist.  
Glücklicherweise ist das Hetzner Control Panel sehr übersichtlich und bietet eine Vielzahl von automatisierten Funktionen, die für die Wartung der Website notwendig sind. Es ist also meist gar __nicht nötig__ manuelle Änderungen vorzunehmen.  
Die folgenden Kapitel umschreiben Kern-Funktionalitäten die Hetzer für die Website übernimmt und gehen auf evtl. Wartungsschritte ein.
### Zugangsdaten
Verwaltet wird der Webhost über eine Weboberfläche von Hetzner ([https://konsoleh.hetzner.com](https://konsoleh.hetzner.com)). Die Zugangsdaten verwaltet das Gymnasium Leopoldinum Passau, da der Account über die Direktorats-E-Mail des Leopoldinums angelegt ist. Auch die anfallenden Rechnungen von (Stand 07.2025) _1,76 €/Monate_ werden durch das Leopoldinum beglichen.
### Domain
Die Domain der Website ist [juedischtogo.de](https://juedischtogo.de). Diese ist mit dem Server bei Hetzner gemietet und wird auch dort verwaltet ([dns.hetzner.com](https://dns.hetzner.com/)). Die Domain ist auf die IP des Servers geroutet und kann dort auch verwaltet werden. Hier ist kein manueller Eingriff nötig, allerdings ist wichtig zu verstehen, dass die Domain Eigentum von Hetzner ist.
### SSL
SSL ist ein Verschlüsselungsprotokoll das den sicheren Austausch von Daten garantiert. Im Browser wird neben der Adresszeile meist ein grünes Schloss oder ein anderes Symbol angezeigt, wenn dieses Protokoll verwendet wird.
Die Website nutzt ein SSL Zertifikat von Let's Encrypt. Dieses wird automatisch alle 3 Monate erneuert und ist somit immer aktuell. Es ist nicht nötig hier manuell einzugreifen. Sollten Probleme mit dem SSL Zertifikat auftreten, ist das daran zu erkennen das entweder das Symbol neben der Adresszeile rot ist oder auf eine andere weiße warnt. Die meisten Browser zeigen sogar eine eigene Oberfläche an, auf der vor Sicherheitsrisiken gewarnt wird. Falls der automatisierte Prozess von Hetzner fehlschlägt, ist eine manuelle Hinterlegung eines SSL Zertifikats zu empfehlen.
Den Prozess, der im Folgenden umschreibe wird, dient nur als „ad hoc" Zwischenlösung und sollte dauerhaft automatisiert werden.
In der Weboberfläche von Hetzner den _juedischtogo.de_ Webhosts auswählen und anschließendes auf Einstellungen > SSL Manager klicken ([Link](https://konsoleh.hetzner.com/sslmanager.php)). Dort kann nun ein neues SSL Zertifikat hochgeladen werden. Bisher wurde hierfür der Service von [ZeroSSL](https://zerossl.com/) verwendet, mit dem Nachteil, dass die Zertifikate der kostenfreien Option nur 90 Tage gültig sind und somit regelmäßig erneuert werden müssen. Darüber hinaus ist dieser Prozess nur 2-mal möglich. Danach muss auf eine Bezahloption umgestiegen werden. Es gibt allerdings zahlreiche SSL Anbieter. Bei der Hinterlegung in Hetzner ist es wichtig zu beachten welcher Schlüssel wo einzutragen ist. In der Regel werden bei allen SSL Anbietern 2 Schlüssel benötigt, den den __Private Key__ und das __Zertifikat__ (Bei Schlüsseln handelt es sich in diesem Kontext um lange zufällige Zeichenketten).
Der ausgestellte Private Key darf aus Sicherheitsgründen __niemals__ an Dritte weitergegeben werden!
Bei Hetzner muss nun auf _Neues Zertifikat > Existierendes Zertifikat_ geklickt werden und das __Zertifikat__ in das Feld "Zertifikatsblock" und der __Private Key__ in das Feld "Schlüsselblock" eingetragen werden.


### Mailboxen
Hetzner bietet auch die Möglichkeit E-Mail-Adressen für die Domain juedischtogo.de zu erstellen. Diese sind über die Weboberfläche von Hetzner unter dem Punkt "Mailboxen" ([Link](https://konsoleh.hetzner.com/mail/mailbox/list)) zu finden. Hier können neue Mailboxen erstellt und verwaltet werden. Auch Passwörter können hier geändert werden. Ein Zugriff erfolgt wie auf der Weboberfläche beschrieben über eigene Mailprogramme (IMAP oder POP3) oder die eigene Weboberfläche von Hetzer [webmail.your-server.de](https://webmail.your-server.de).

### FTP Accounts
Der Zugriff auf die gesamte Ordnerstruktur der Website ist nur über FTP möglich, da der Webserver selbst nur Zugriff auf den sogenannten Web-Root, also den Ordner, in dem die Website Dateien liegen, hat. Ein Account hierfür kann über die Weboberfläche von Hetzner unter _Einstellungen > Logindaten_ angelegt werden. Es ist nun möglich über einen FTP Client (z.B. FileZilla) oder Hetzners WebFTP Client im Browser ([Link](https://konsoleh.hetzner.com/webftp.php)) auf die Dateien des Servers zuzugreifen.

### PHP Version/Serverspezifische Konfiguration
Im Folgenden wird hauptsächlich auf die Einstellungen in _Einstellungen > PHP Konfiguration_ eingegangen. PHP ist sozusagen der Motor, auf dem die Website läuft und sollte immer mit der aktuellsten (höchsten) PHP-Version betrieben werden. Die Auswahl der Version erfolgt über das Dropdown Menü. Zum Stand 07.2025 ist die PHP Version 8.4 die neueste Version, welche von der Website unterstützt wird. Wenn eine neue PHP-Version Kompatibilitätsprobleme erzeugen sollte, dann muss eine fachkundige Person die Programmierung der Website anpassen. 

Auf die Existenz der Serverspezifischen Konfigurationen wird hingewiesen. Weiterführende Ausführungen werden an dieser Stelle nicht gemacht, da Probleme, die in diesem Bereich auftreten, generell nur durch eine Fachperson gelöst werden können.

## Website
Die Website ist dank ihrer Implementierung in WordPress sehr einfach zu bedienen. Viele Einstellungsmöglichkeiten sind rein Grafisch und auch für einen Laien leicht zu bedienen. Dies war auch ein Ziel bei der Implementierung, da der Großteil der Wartungsarbeit hier auf der Website selber stattfinden wird.

Im Folgenden wird nur auf die Aspekte eingehen, die über die Grundfunktionen von WordPress hinausgehen, da Wordpress eine weitreichend verwendete Technologie ist, für die bereits eine umfassende Dokumentation existiert.

### Zugangsdaten
Für den Zugriff auf das Dashboard der Website ([juedischtogo.de/admin](https://juedischtogo.de/admin)) sind Zugangsdaten nötig. Diese können in WordPress durch den Administrator hinterlegt werden.


Allgemein ist der Zugriff auf die Website derzeit beschränkt. Dies hat rechtliche Gründe. Der Code für den Zugang wird aus Sicherheitsgründen hier nicht erwähnen.

### Custom Theme: jtg WordPress Theme
Die Implementierung der Website-eigenen Funktionen über die Grundfunktionen von WordPress hinaus findet im jtg WordPress Theme statt. Dieses Theme ist speziell für die Jüdisch to go Website entwickelt worden. Es ist folglich wichtig das dieses Theme auch ausgewählt ist.

#### Orte
In der Seitenleiste des Dashboards sind neben Beiträgen und Seiten auch Orte zu finden. Diese sind essenzieller Bestandteil der Website und beherbergen ihre eigene Funktionalität. Anzulegen sind Orte wie jeder andere WordPress Beitrag auch. Auch die Bearbeitung des Inhalts ist identisch. Orte haben allerdings darüber hinaus die Möglichkeit mit speziellen _Individuellen Feldern_ ausgestattet zu werden, auf die im Folgenden eingangen wird:
- __address__: In dieses Feld kann eine Adresse eingetragen werden. Diese wird benötigt, um auf dem Map shortcode den Ort auch an der richtigen Stelle anzuzeigen. Da die Adresse intern über den Service [https://nominatim.openstreetmap.org/](https://nominatim.openstreetmap.org/) auf eine Geo-Koordinate umgewandelt wird, ist zu empfehlen bei fehlerhafter Anzeige der Adresse die Documentation des Servicen [https://nominatim.org/release-docs/latest/api/Search/#free-form-query](https://nominatim.org/release-docs/latest/api/Search/#free-form-query) zu konsultieren. Hier ist zu beachten, dass die Adresse in der Regel in keinem bestimmten Format angegeben werden muss damit sie richtig interpretiert wird. Es reicht daher aus die Adresse wie gewohnt anzugeben.  
Es wird unterstützt, dass Orte mehr als nur eine Adresse besitzen. Diese werden dann alle angezeigt.
- __map_show__: Dieses Feld ist optional. Es kann auf "_false_" gesetzt werden um zu verhindern, dass der Ort auf dem Map Shortcode angezeigt wird. Ist er nicht gesetzt oder auf "_true_" gesetzt wird er angezeigt.

- __map_title__: Dieses Feld ist optional. Es überschreibt den Titel des Ortes, der auf der Map angezeigt zu werden. Ist es nicht gesetzt wird der Titel des Ortes verwendet.

- __map_pin_style__: Dieses Feld ist optional. Im Verzeichnis des Themes befindet sich ein Ordner "./assets/pictures/markers". In diesem befinden sich verschiedene Marker die als Pin auf der Karte angezeigt werden zu können. Steht der Wert des Feldes hier also auf "_blue_" so wird der marker "_marker-blue.svg_" verwendet. Ist das Feld nicht gesetzt wird der "_marker-default.svg_" verwendet.

- __date__: Dieses Feld ist optional und findet aktuell keine Verwendung auf der Website. Es kann verwendet werden, um den Ort auf dem Timeline shortcode anzuzeigen. Es dabei lediglich möglich eine Jahreszahl anzugeben.

#### Design Customizor
Der Design Customizor ist ein WordPress Feature, das es ermöglicht das Design der Website anzupassen. Hier können Farben, Schriftarten und andere Designelemente angepasst werden. Es ist wichtig zu beachten das diese Änderungen nur für das aktuell ausgewählte Theme gelten. Das jtg WordPress Theme hat bereits einige Voreinstellungen die für die Jüdisch to go Website optimiert sind, fügt aber auch viele eigene hinzu. Es wird empfohlen bei Anzeigefehlern erst hier Einstellungen vorzunehmen.


### Plugins
Die Website verwendet eigene Plugins die entweder die Benutzung oder die Erfahrung verbessern. Im Folgenden wird kurz beschrieben, wofür welche Plugins verwendet werden und inwiefern diese relevant für Funktionen der Website sind.

- **Password Protected**: Dieses Plugin schützt die gesamte Website mit einem Passwort.
- **Redirection**: Dieses Plugin ermöglicht es Weiterleitungen einzurichten. Diese sind essenziell für die Funktion der QR-Codes und Tafeln. Weitere Informationen sind im entsprechenden Unterkapitel zu finden.
- **Performance + W3 Total Cache**: Dieses Plugin verbessert die Performance der Website durch Caching und andere Optimierungen. Es ist damit nicht relevant für die Funktion der Website.
- **Error Log Monitor**: Dieses Plugin überwacht die Fehlerprotokolle der Website und benachrichtigt den Administrator bei Fehlern. Es dient damit der reinen Übersichtlichkeit und ist nicht relevant für die Funktion der Website.
- **Login Designer**: Dieses Plugin ermöglicht es das Design der Login Seite anzupassen. Es ist damit nicht relevant für die Funktion der Website.
- **WP Datei Manager**: Dieses Plugin ermöglicht es Dateien auf dem Server zu verwalten. Es ist damit nicht relevant für die Funktion der Website, kann aber bei der Wartung hilfreich sein.

### Shortcodes
Shortcodes sind eine nützliche WordPress Funktion mit der eigene Bausteine erstellt und in Beiträge eingegliedert werden können. Das WordPress Theme implementiert viele dieser shortcode’s, auf die im Folgenden eingegangen wird:
- **"map"**: Dieser shortcode implementiert die Karte der Website. Er zeigt alle Orte an die eine korrekte Adresse eingetragen haben. Über diese Funktion hinaus können weitere Parameter an den shortcode übergeben werden.  

 | Name | Wert | Beschreibung |
 | ---- | ---- | ---- |
 _width_ | Zulässige CSS Werte ([Link](https://developer.mozilla.org/en-US/docs/Web/CSS/width#values)) | Die Breite der Karte. Da diese Einstellung als CSS Wert für width weitergegeben wird, sind alle CSS Werte zulässig. Standard ist 100% |
 _height_ | Zulässige CSS Werte ([Link](https://developer.mozilla.org/en-US/docs/Web/CSS/height#values)) | Die Höhe der Karte. Da diese Einstellung als CSS Wert für height weitergegeben wird, sind alle CSS Werte zulässig. Standard ist 40svh
 | _interactive_ | true/false | Ob die Karte interaktiv sein soll. Wenn auf _true_ gesetzt kann die Karte verschoben und gezoomt werden. Standard ist _true_ |
| _overwrite_address_ | true/false | Die Karte ist standardmäßig auf die Mitte der Passauer Innenstadt zentriert. Sollte auf eine andere Adresse zentriert werden, ist diese hier einzutragen. |
| _overwrite_zoom_ | Ganzzahl | Kartenzoom. Hier existiert kein wirklicher Maßstab, an dem sich orientiert werden kann, es wird empfohlen die Werte flexibel auszuprobieren. |
| _location_post_id_ | Ganzzahl | Falls nur ein Ort auf der Karte angezeigt werden soll, kann hier die ID des Posts angegeben werden. Diese kann im Dashboard unter „Orte“ eingesehen werden. |

- **"post"**: Dieser shortcode implementiert einen Steckbrief eines Beitrags oder eines Ortes. Er zeigt das Thumbnail, den Titel und eine kleine Zusammenfassung des Beitrags an.

| Name | Wert | Beschreibung |
| ---- | ---- | ---- |
| _post_id_ | Ganzzahl | Die ID des Beitrags der angezeigt werden soll. Diese kann im Dashboard unter „Beiträge“ eingesehen werden. |
| _title_ | String | Der Titel des Beitrags der angezeigt werden soll. Wenn nicht angegeben wird der Titel des Beitrags verwendet. |
| _excerpt_ | String | Die Zusammenfassung des Beitrags die angezeigt werden soll. Wenn nicht angegeben wird die Zusammenfassung des Beitrags verwendet. |

- **"postgallery"**: Dieser shortcode implementiert eine Gallery in der _post_ shortcode’s horizontal nebeneinander angezeigt werden. Diese können dann durch Klicken auf Pfeile durchgeklickt und angezeigt werden. Die Übergabe der _post_’s ist dabei wie folgt möglich:
```
[postgallery]
[post post_id=1]
[post post_id=2]
[post post_id=3]
...
[/postgallery]
```
- **"timeline"**: Dieser shortcode implementiert eine Zeitleiste die alle Orte anzeigt, die ein Datum eingetragen haben. Diese werden chronologisch sortiert angezeigt.

| Name | Wert | Beschreibung |
| ---- | ---- | ---- |
| _show_dates_ | true/false | Ob die Daten der Orte angezeigt werden sollen. Standard ist _true_. |
| _show_title_ | true/false | Ob der Titel des Ortes angezeigt werden soll. Standard ist _true_. |
| _post_ids_ | Kommagetrennte Kette von Ganzzahlen | Die IDs der Orte die angezeigt werden sollen. Wenn nicht angegeben, werden alle Orte angezeigt. Diese können im Dashboard unter „Orte“ eingesehen werden. |

### QR-Codes / Tafeln
Die Tafeln mit den QR-Codes sind ein wichtiger Bestandteil des Konzepts der Website. Sie ermöglichen die Verlinkung zu den Orten und Beiträgen der Website. Die QR Codes sind dabei so generiert das sie auf statische Teile der Website verlinken. So verweist der erste QR-Code auf [juedischtogo.de/tafel1](https://juedischtogo.de/tafel1) und der zweite auf [juedischtogo.de/tafel2](https://juedischtogo.de/tafel2) und so weiter. Auf diese Weise lassen sich die Beiträge auf die QR Codes verweisen immer ändern.  
Hierfür wird das **Redirection** Plugin verwendet. Dieses Plugin ermöglicht es die `/tafel*` URLs auf andere umzuleiten. Die Einstellungen hierfür befinden sich unter den Einstellungen des Plugins ([Link](https://juedischtogo.de/wp-admin/tools.php?page=redirection.php)). Hier können auch neue Weiterleitungen hinzugefügt werden.
