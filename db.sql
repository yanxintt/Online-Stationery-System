CREATE DATABASE stationery CHARACTER SET utf8 COLLATE utf8_general_ci;

USE stationery;


CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY,
    image VARCHAR(255),
    name VARCHAR(255),
    price DECIMAL(10, 2),
    description TEXT
);

INSERT INTO products (id, image, name, price, description) VALUES
    (1, 'images/item1.png', '80ml Stick Up White Glue (Non-toxic)', 3.50, '80ml white glue suitable for various crafting and sticking purposes. Non-toxic formula.'),
    (2, 'images/item2.png', 'Fountain Pen Luxury Style (free a jar of ink)', 149.99, 'A luxurious fountain pen known for its styles and elegance. Comes with a complimentary jar of ink. Fountain pen typically requires ink refills.'),
    (3, 'images/item3.png', 'Set of 6 Different Color Highlight Pen', 15.00, 'A set of six highlighter pens in different colors. Suitable for marking important sections in documents and notes.'),
    (4, 'images/item4.png', 'Classic 24 Colors Oil Color Pencil Set', 23.60, 'A set of 24 oil-based colored pencils. Ideal for drawing and coloring.'),
    (5, 'images/item5.png', 'Different Colors of Marker Pen,6pcs', 22.00, 'A pack of 6 marker pens in assorted colors. Suitable for various writing and marking tasks.'),
    (6, 'images/item6.png', 'Red Color Medium Size Stapler', 3.55, 'Medium-sized stapler in red color. Suitable for stapling documents together.'),
    (7, 'images/item7.png', 'Economy Children Safe Paper Small Scissors,1pcs', 1.70, 'Small-sized scissors designed with childrens safety in mind. Suitable for crafting and school projects.'),
    (8, 'images/item8.png', 'Easy Grip Medium Size Colorful Binder Clips(12pcs)', 6.00, 'A pack of 12 medium-sized binder clips with colorful, easy-grip handles. Suitable for organizing paper and documents. For school and office use.'),
    (9, 'images/item9.png', '10PCS Water Brush Set*NYLON WOOLS', 12.00, 'A set of 10 water brushes with NYLON wool tips. Ideal for watercolor painting and blending techniques.'),
    (10, 'images/item10.png', 'Paper Clips Multicolor 450pcs for Office School Supplies', 4.30, 'A pack of 450 multicolor paper clips. Suitable for office and school use.'),
    (11, 'images/item11.png', '2pcs Ball Pen(1 blue+1 black)', 3.50, 'A pack of 2 ballpoint pens, one blue and one black. Suitable for everyday writing tasks.'),
    (12, 'images/item12.png', 'Mixed Color Colorful Crayon,12pcs in 1 box', 9.90, 'Box containing 12 colorful crayons in assorted shades. Ideal for drawing and coloring.'),
    (13, 'images/item13.png', 'Big Size Pelikan BR40 Eraser 1pcs', 3.60, 'Large-sized Pelikan BR40 eraser. Suitable for erasing pencil marks cleanly.'),
    (14, 'images/item14.png', 'Twin Hole Pencil Sharpener,1pcs', 1.00, 'Pencil sharpener with twin holes. Suitable for sharpening standard and large-sized pencils.'),
    (15, 'images/item15.png', '350pages Dot Notepad A5 hardcover notebook', 21.00, 'A5-sized hardcover notebook with dotted pages. Containing 350 pages for notes and sketches.'),
    (16, 'images/item16.png', '200pages Dot Notepad A5 notebook', 9.00, 'A5-sized notebook with dotted pages. Containing 200 pages for various purposes.'),
    (17, 'images/item17.png', 'Box of 2B pencils,12pcs', 6.00, 'Box containing 12 pencils with 2B lead hardness. Suitable for writing, sketching, and exam use.'),
    (18, 'images/item18.png', '1pcs 0.5mm Blue Gel Pen', 1.30, 'Gel pen with blue ink. 0.5mm tip size. Suitable for smooth writing and exam use.'),
    (19, 'images/item19.png', '0.7mm Red Gel Pen,1pcs', 1.50, 'Gel pen with red ink. 0.7mm tip size. Suitable for various writing tasks.'),
    (20, 'images/item20.png', '1pcs 0.5mm Black Gel Pen', 1.30, 'Gel pen with black ink. 0.5mm tip size. Suitable for precise and smooth writing.');

CREATE TABLE carts (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  user_id INT(11),
  item_id INT(11),
  quantity INT(11)
);

CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(255),
  password VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS contact (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255) NOT NULL,
    message TEXT NOT NULL
);