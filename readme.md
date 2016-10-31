# Joomla.de Repository

[Joomla.de](https://joomla.de) - Joomla.de, die deutschsprachige Landesseite des preisgekrönten Open Source Content Management Systems Joomla.

## Mitarbeit erwünscht!

Die Joomla.de Website wird von einer Gruppe von freiwilligen Joomlaholics betrieben. Jeder, der sich an der Weiterentwicklung der Website - sei es technisch, inhaltlich oder gestalterisch - beteiligen möchte, ist dazu herzlich eingeladen!

Als Kommunikationsplatform benutzen wie den Chat-Client [Glip](https://glip.com/). Schick einfach eine Anfrage an <david.jardin@community.joomla.org> und du wirst in die Joomla.de Gruppe eingeladen.

## Fehler & Änderungswünsche

Du hast einen Fehler gefunden oder einen Verbesserungs-/Änderungsvorschlag? Wir freuen uns, wenn du dafür ein [Issue erstellst](https://github.com/JandBeyond/joomlade/issues/new).

## Code Änderungen

Das Repository enthält nur die Dateien, die von uns modifiziert wurden. 

Wir benutzen eine auto-deployment System, welches alle Änderungen in den dev und master branches automatisch mit unserem Webserver synchronisiert. Änderungen an dem master branch sind daher nur via Pull-Request zulässig. 

Solltest du Fragen bei der Einrichtung oder Probleme mit der Entwicklungsumgebung haben, melde Dich einfach bei uns im Chat. Wir helfen gerne!

## Template Änderungen

In unserem Template benutzen wir den Task Runner [Grunt](http://gruntjs.com/). Mit Hilfe von grunt werden bspw. die less Dateien kompiliert und die fertigen css Dateien minifiziert.
Um Änderungen am Template, den Stylesheets oder Javascript Dateien vorzunehmen, musst du daher Grunt einrichten:

1) Öffne das Terminal und wechsel in das joomlade Template Verzeichnis:

	cd /src/templates/joomlade

2) Als nächstes installierst du mit Bower die externen Bibliotheken (bootstrap, fontawesome, jquery). Solltest du bower nicht lokal installiert haben, findest du auf der [Bower-Website](https://bower.io/) eine Installationsanleitung.

	bower install

3) Installiere Grunt und die von uns benötigten Grunt Plugins mit folgendem Befehl: 

	npm install
	
4) Starte den Watcher, der seine Arbeit immer dann erledigt, wenn Du Änderungen an den Template-Dateien vornimmst.	

	grunt watch
	
Wenn alles fehlerfrei funktioniert hat, kannst du jetzt Änderungen am Template durchführen. Bitte ändere die css Dateien nicht manuell, sondern ändere/erweitere die entsprechenden less Dateien und benutze den Watcher.

