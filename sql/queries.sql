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
