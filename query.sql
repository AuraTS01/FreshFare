CREATE TABLE fresh_fare_signup (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `mob_num` bigint(200) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` varchar(2000) NOT NULL,
  `category` varchar(2000) NOT NULL,
  `access` int(100) NOT NULL,
  `country` varchar(2000) NOT NULL,
  `Address_1` varchar(2000) NOT NULL,
  `Address_2` varchar(2000) NOT NULL,
  `town` varchar(2000) NOT NULL,
  `state` varchar(2000) NOT NULL,
  `zipCode` int(200) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT,
    order_id VARCHAR(100),
    order_date DATETIME,
    payment_mode VARCHAR(50),
    total_price DECIMAL(10,2),
    FOREIGN KEY (customer_id) REFERENCES customers(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    item_name VARCHAR(100),
    quantity FLOAT,
    unit VARCHAR(10),
    price DECIMAL(10,2),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

ALTER TABLE order_items ADD customer_id INT AFTER order_id;

ALTER TABLE order_items
  ADD CONSTRAINT fk_customer_order_items
  FOREIGN KEY (customer_id)
  REFERENCES fresh_fare_signup(id)
  ON DELETE CASCADE;


CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT,
  customer_id INT,
  item_name VARCHAR(255),
  quantity INT,
  unit VARCHAR(10),
  price DECIMAL(10,2)
);


CREATE TABLE company_registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    company_address TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    selling_items TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
