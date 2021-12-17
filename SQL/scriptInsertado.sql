
-- Añado un usuario (pruebas)
INSERT INTO usuarios(nombre,apellido,correo,pw) VALUES ('admin','evg','a@evg.es','1234');

-- Insertar minijuegos

INSERT INTO Minijuegos(nombre,enlace) 
VALUES 
('FlashCards','/flashcards'),
('Reciclaje','/reciclaje'),
('Ligas','/ligas'),
('Tabla periodica','/tperiodica');

-- Preferencias del usuario de pruebas
INSERT INTO preferencias VALUES
(1,1),
(3,1)
