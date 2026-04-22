// pexels_herons.js
// Lädt automatisch Fotos von Fischreihern (grey heron) von der Pexels API herunter
// und speichert sie lokal ab.

// Importiert Module für Dateisystem- und Pfad-Operationen
import fs from "node:fs/promises";
import path from "node:path";

// ------------------ API-Konfiguration ------------------

// API Key von Pexels (hier direkt eingetragen – besser wäre .env-Datei)
const KEY = "Gey4u6oJlGses1jze0bnq2Jb6XxS1y5V4CV4Kzh7L4drHca1NEGYP286";

// Suchbegriff – was wir bei Pexels suchen wollen
const QUERY = "grey heron"; // englisch: Graureiher

// Wie viele Bilder pro Seite und wie viele Seiten
const PER_PAGE = 80; // max. 80 laut Pexels-Doku
const PAGES = 4;     // z. B. 3 Seiten à 80 = 240 Bilder

// Zielordner, in dem die Fotos gespeichert werden
const OUTPUT = "./pexels_reiher";

// -------------------------------------------------------

// Hilfsfunktion: pausiert den Code für X Millisekunden (z. B. um API nicht zu überlasten)
async function sleep(ms){
    return new Promise(r => setTimeout(r, ms));
}

// Hauptfunktion
async function main() {
    // Wenn kein API Key vorhanden ist, abbrechen
    if (!KEY) throw new Error("Setze PEXELS_API_KEY in der Umgebung oder direkt im Script.");

    // Ordner anlegen, falls er noch nicht existiert
    await fs.mkdir(OUTPUT, { recursive: true });

    // Schleife über mehrere Seiten (1, 2, 3, …)
    for (let page = 1; page <= PAGES; page++) {

        // URL für API-Anfrage zusammensetzen
        const url = `https://api.pexels.com/v1/search?query=${encodeURIComponent(QUERY)}&per_page=${PER_PAGE}&page=${page}`;

        // Anfrage an die Pexels API senden, mit unserem API Key im Header
        const resp = await fetch(url, { headers: { Authorization: KEY }});

        // Prüfen, ob Anfrage erfolgreich war
        if (!resp.ok) throw new Error(`HTTP Fehler ${resp.status}`);

        // Antwort in JSON umwandeln
        const data = await resp.json();

        // Über alle Fotos auf dieser Seite gehen
        for (const ph of data.photos ?? []) {

            // Bild-URL (Original oder große Version)
            const src = ph.src?.original || ph.src?.large || ph.src?.large2x;
            if (!src) continue; // Wenn keine URL vorhanden, überspringen

            // Dateiname aus der Bild-ID + Dateiname der Quelle zusammensetzen
            const fname = `${ph.id}_${path.basename(new URL(src).pathname)}`.slice(0, 180);

            // Bilddatei von der URL herunterladen
            const img = await fetch(src);
            if (!img.ok) continue; // Wenn Download fehlschlägt, überspringen

            // In einen Buffer umwandeln (Rohdaten)
            const buf = Buffer.from(await img.arrayBuffer());

            // Datei im Ausgabeordner speichern
            await fs.writeFile(path.join(OUTPUT, fname), buf);

            // Erfolgsmeldung in der Konsole
            console.log(`Gespeichert: ${fname}`);

            // Kleine Pause zwischen Downloads (200 ms)
            await sleep(200);
        }

        // Nach jeder Seite etwas warten (500 ms)
        await sleep(500);
    }

    // Wenn alles fertig ist:
    console.log("Fertig. Alle Reiher-Bilder heruntergeladen!");
}

// Startet das Script
// Wenn Fehler auftreten, werden sie ausgegeben und Node beendet sich mit Fehlercode
main().catch(e => {
    console.error(e);
    process.exit(1);
});
