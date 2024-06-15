CREATE DATABASE database;

USE database;

CREATE TABLE `users`
(
    `id`        INT AUTO_INCREMENT PRIMARY KEY,
    `email`     VARCHAR(255) NOT NULL UNIQUE,
    `password`  VARCHAR(255) NOT NULL,
    `lastname`  VARCHAR(255) NOT NULL,
    `firstname` VARCHAR(255) NOT NULL
);

CREATE TABLE `products`
(
    `id`    INT AUTO_INCREMENT PRIMARY KEY,
    `name`  VARCHAR(255)   NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL
);

CREATE TABLE `orders`
(
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `user_id`    INT            NOT NULL,
    `total`      DECIMAL(10, 2) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
);

CREATE TABLE `order_items`
(
    `id`         INT AUTO_INCREMENT PRIMARY KEY,
    `order_id`   INT            NOT NULL,
    `product_id` INT            NOT NULL,
    `quantity`   INT            NOT NULL,
    `price`      DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
    FOREIGN KEY (`product_id`) REFERENCES `products` (`id`)
);

/* insert products */
INSERT INTO products (name, price)
VALUES ('Ordinateur portable', 799.99);
INSERT INTO products (name, price)
VALUES ('Smartphone', 699.99);
INSERT INTO products (name, price)
VALUES ('Tablette', 349.99);
INSERT INTO products (name, price)
VALUES ('Écouteurs sans fil', 129.99);
INSERT INTO products (name, price)
VALUES ('Montre connectée', 199.99);
INSERT INTO products (name, price)
VALUES ('Clavier mécanique', 89.99);
INSERT INTO products (name, price)
VALUES ('Souris de jeu', 49.99);
INSERT INTO products (name, price)
VALUES ('Écran 24 pouces', 149.99);
INSERT INTO products (name, price)
VALUES ('Disque dur externe 1TB', 59.99);
INSERT INTO products (name, price)
VALUES ('Imprimante multifonction', 119.99);
INSERT INTO products (name, price)
VALUES ('Caméra de sécurité', 99.99);
INSERT INTO products (name, price)
VALUES ('Routeur Wi-Fi', 79.99);
INSERT INTO products (name, price)
VALUES ('Casque de réalité virtuelle', 299.99);
INSERT INTO products (name, price)
VALUES ('Microphone USB', 69.99);
INSERT INTO products (name, price)
VALUES ('Webcam HD', 39.99);
INSERT INTO products (name, price)
VALUES ('Haut-parleurs Bluetooth', 59.99);
INSERT INTO products (name, price)
VALUES ('Lecteur de carte mémoire', 19.99);
INSERT INTO products (name, price)
VALUES ('Chargeur sans fil', 29.99);
INSERT INTO products (name, price)
VALUES ('Batterie externe', 49.99);
INSERT INTO products (name, price)
VALUES ('Station de charge USB', 34.99);
