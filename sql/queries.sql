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

-- Vraag: welke gebruiker hoort bij dit e-mailadres, en wat is zijn rol? (login)
SELECT users.*, roles.name AS role
FROM users
LEFT JOIN roles ON users.role_id = roles.id
WHERE users.email = 'milo@example.com';

-- Vraag: heeft deze klant al een aanvraag voor dit dier ingediend?
SELECT id FROM adoption_requests WHERE user_id = 1 AND animal_id = 1;

-- Vraag: welke aanvragen heeft deze klant gedaan, met dier en soort erbij?
SELECT adoption_requests.*, animals.name AS animal_name, species.name AS species_name
FROM adoption_requests
LEFT JOIN animals ON animals.id = adoption_requests.animal_id
LEFT JOIN species ON species.id = animals.species_id
WHERE adoption_requests.user_id = 1
ORDER BY adoption_requests.request_date DESC;

-- Vraag: welke aanvragen zijn er, met het dier en de aanvrager erbij?
SELECT adoption_requests.*, animals.name AS animal_name, users.name AS user_name
FROM adoption_requests
LEFT JOIN animals ON animals.id = adoption_requests.animal_id
LEFT JOIN users ON users.id = adoption_requests.user_id
ORDER BY adoption_requests.request_date DESC;

-- Vraag: welke dieren hebben nog geen enkele aanvraag gekregen?
SELECT animals.*, species.name AS species_name
FROM animals
LEFT JOIN species ON species.id = animals.species_id
LEFT JOIN adoption_requests ON adoption_requests.animal_id = animals.id
WHERE adoption_requests.id IS NULL
  AND animals.deleted_at IS NULL;

-- Vraag: wie heeft wat gedaan in het beheergedeelte? (logboek)
SELECT logs.*, users.name AS user_name, animals.name AS animal_name
FROM logs
LEFT JOIN users ON users.id = logs.user_id
LEFT JOIN animals ON animals.id = logs.animal_id
ORDER BY logs.created_at DESC;

-- Vraag: hoeveel dieren hebben we per soort?
SELECT species.name, COUNT(*) AS aantal
FROM animals
LEFT JOIN species ON species.id = animals.species_id
WHERE animals.deleted_at IS NULL
GROUP BY species.id, species.name;

-- Vraag: wat is de gemiddelde, laagste en hoogste adoptieprijs?
SELECT AVG(price) AS gemiddelde, MIN(price) AS laagste, MAX(price) AS hoogste
FROM animals
WHERE deleted_at IS NULL;

-- Vraag: hoeveel hebben goedgekeurde adopties dit jaar opgebracht?
SELECT SUM(animals.price) AS opbrengst
FROM adoption_requests
LEFT JOIN animals ON animals.id = adoption_requests.animal_id
WHERE adoption_requests.status = 'goedgekeurd';

-- Vraag: welke soorten hebben meer dan drie aanvragen gekregen?
SELECT species.name, COUNT(*) AS aantal_aanvragen
FROM adoption_requests
LEFT JOIN animals ON animals.id = adoption_requests.animal_id
LEFT JOIN species ON species.id = animals.species_id
GROUP BY species.id, species.name
HAVING COUNT(*) > 3;
