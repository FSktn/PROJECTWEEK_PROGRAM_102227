-- Database schema for ESA Space Objects
-- Create the ruimteObjecten table

CREATE TABLE IF NOT EXISTS ruimteObjecten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    naam VARCHAR(255) NOT NULL,
    type VARCHAR(100) NOT NULL,
    omschrijving TEXT NOT NULL,
    afbeelding VARCHAR(255) NOT NULL,
    upload_datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
