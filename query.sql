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
    FOREIGN KEY (customer_id) REFERENCES fresh_fare_signup(id)
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
CREATE TABLE item_price (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    chicken_with_skin_price DECIMAL(10,2) DEFAULT 0,
    chicken_without_skin_price DECIMAL(10,2) DEFAULT 0,
    prawn_price DECIMAL(10,2) DEFAULT 0,
    mutton_price DECIMAL(10,2) DEFAULT 0,
    fish_price DECIMAL(10,2) DEFAULT 0,
    FOREIGN KEY (company_id) REFERENCES company_registration(company_id) ON DELETE CASCADE
);
ALTER TABLE item_price ADD Kadai_price DECIMAL(10,2) DEFAULT 0

ALTER TABLE company_registration
ADD CONSTRAINT fk_company_signup
FOREIGN KEY (id) REFERENCES fresh_fare_signup(id)
ON DELETE CASCADE
ON UPDATE CASCADE;


------------------------------------------------------- NEW QUERY -----------------------------------

CREATE TABLE fresh_fare_signup (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mob_num BIGINT NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(2000) NOT NULL,
    category VARCHAR(2000) NOT NULL,
    access INT NOT NULL,
    country VARCHAR(2000) NOT NULL,
    Address_1 VARCHAR(2000) NOT NULL,
    Address_2 VARCHAR(2000) NOT NULL,
    town VARCHAR(2000) NOT NULL,
    state VARCHAR(2000) NOT NULL,
    zipCode INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE company_registration (
    company_id INT AUTO_INCREMENT PRIMARY KEY,
    signup_id INT NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    company_address TEXT NOT NULL,
    email VARCHAR(255) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    selling_items TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_company_signup FOREIGN KEY (signup_id) REFERENCES fresh_fare_signup(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE item_price (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    company_id INT NOT NULL,
    chicken_with_skin_price DECIMAL(10,2) DEFAULT 0,
    chicken_without_skin_price DECIMAL(10,2) DEFAULT 0,
    prawn_price DECIMAL(10,2) DEFAULT 0,
    mutton_price DECIMAL(10,2) DEFAULT 0,
    fish_price DECIMAL(10,2) DEFAULT 0,
    CONSTRAINT fk_itemprice_company FOREIGN KEY (company_id) REFERENCES company_registration(company_id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_id INT NOT NULL,
    order_code VARCHAR(100) NOT NULL,
    order_date DATETIME,
    payment_mode VARCHAR(50),
    total_price DECIMAL(10,2),
    CONSTRAINT fk_orders_customer FOREIGN KEY (customer_id) REFERENCES fresh_fare_signup(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    item_name VARCHAR(100),
    quantity FLOAT,
    unit VARCHAR(10),
    price DECIMAL(10,2),
    CONSTRAINT fk_orderitems_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB;


ALTER TABLE orders
ADD COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending';

ALTER TABLE order_items 
ADD COLUMN company_id INT NOT NULL AFTER order_id;

ALTER TABLE order_items ADD COLUMN pickup_status ENUM('pending','picked') DEFAULT 'pending';




ALTER TABLE item_price ADD COLUMN kadai_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN mutton_boti_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN mutton_Liver_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN beef_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN beef_liver_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN beef_boti_price DECIMAL(10,2) DEFAULT 0;
ALTER TABLE item_price ADD COLUMN duck_price DECIMAL(10,2) DEFAULT 0;




ALTER TABLE orders ADD COLUMN company_id INT AFTER customer_id;

ALTER TABLE order_items MODIFY pickup_status VARCHAR(10);
ALTER TABLE orders MODIFY status VARCHAR(10);
ALTER TABLE orders 
MODIFY status ENUM('pending','acknowledged','dispatched','OPOD','delivered', 'partially_picked','picked') NOT NULL;



-- ALTER TABLE order_items 
-- ADD CONSTRAINT fk_orderitems_company 
-- FOREIGN KEY (company_id) REFERENCES company_registration(company_id) 
-- ON DELETE CASCADE;