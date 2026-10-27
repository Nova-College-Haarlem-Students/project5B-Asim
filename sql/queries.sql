-- Vraag: welke dieren zijn beschikbaar, gesorteerd op naam?
SELECT a.*, s.name AS species_name
FROM animals a
LEFT JOIN species s ON s.id = a.species_id
WHERE a.deleted_at IS NULL
ORDER BY a.name ASC;

-- Vraag: welke dieren zijn beschikbaar, gefilterd op soort (hond) en geslacht (man)?
SELECT a.*, s.name AS species_name
FROM animals a
LEFT JOIN species s ON s.id = a.species_id
WHERE a.deleted_at IS NULL
  AND a.species_id = 1
  AND a.gender = 'man';

-- Vraag: welke soorten dieren hebben we, zonder dubbele waardes?
SELECT DISTINCT s.id, s.name
FROM species s
ORDER BY s.name;

-- Vraag: wat zijn de details van één specifiek dier?
SELECT a.*, s.name AS species_name
FROM animals a
LEFT JOIN species s ON s.id = a.species_id
WHERE a.id = 1
  AND a.deleted_at IS NULL;

-- Vraag: welke dieren zijn het duurst (prijs hoog naar laag)?
SELECT a.*, s.name AS species_name
FROM animals a
LEFT JOIN species s ON s.id = a.species_id
WHERE a.deleted_at IS NULL
ORDER BY a.price DESC;
