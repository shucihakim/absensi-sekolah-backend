ALTER TABLE guru ADD COLUMN verified tinyint(1) DEFAULT 0 AFTER gambar;
ALTER TABLE murid ADD COLUMN verified tinyint(1) DEFAULT 0 AFTER gambar;
ALTER TABLE ortu ADD COLUMN verified tinyint(1) DEFAULT 0 AFTER gambar;

UPDATE guru SET verified = 1;
UPDATE murid SET verified = 1;
UPDATE ortu SET verified = 1;