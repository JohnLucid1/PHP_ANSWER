create TABLE notebook (
    id serial primary key, 
    full_name varchar(255) not null, 
    company varchar(255),
    phone_number varchar(20) not null, 
    email varchar(255) not null, 
    birth_date DATE, 
    photo BYTEA
);

INSERT INTO notebook (full_name, company, phone_number, email, birth_date, photo)
VALUES 
    ('John Doe', 'ABC Company', '1234567890', 'john.doe@example.com', '1985-05-15', NULL),
    ('Jane Smith', 'XYZ Corporation', '9876543210', 'jane.smith@example.com', '1990-10-25', NULL),
    ('Michael Johnson', '123 Industries', '5551112233', 'michael.j@example.com', '1988-07-07', NULL),
    ('Alice Brown', 'Tech Solutions', '1112223344', 'alice.b@example.com', '1995-03-18', NULL),
    ('David Lee', 'Global Ventures', '9998887766', 'david.lee@example.com', '1982-12-30', NULL),
    ('Mark Wilson', 'Tech Enterprises', '7778889999', 'mark.w@example.com', '1993-08-12', NULL),
    ('Emily Johnson', 'Innovate Corp', '4445556666', 'emily.j@example.com', '1989-04-22', NULL),
    ('Christopher White', 'Digital Solutions', '3332221111', 'chris.w@example.com', '1997-01-05', NULL),
    ('Emma Davis', 'Data Systems', '2223334444', 'emma.d@example.com', '1987-11-29', NULL),
    ('Daniel Thomas', 'InfoTech Ltd', '6665554444', 'daniel.t@example.com', '1984-06-14', NULL),
    ('Sophia Lee', 'Web Services', '5556667777', 'sophia.l@example.com', '1992-02-08', NULL),
    ('Matthew Brown', 'Mobile Solutions', '7779991111', 'matthew.b@example.com', '1991-09-17', NULL),
    ('Olivia Martin', 'Smart Systems', '8887776666', 'olivia.m@example.com', '1986-12-03', NULL),
    ('William Clark', 'Network Technologies', '3334445555', 'william.c@example.com', '1983-10-20', NULL),
    ('Ava Hall', 'Cyber Innovations', '6667778888', 'ava.h@example.com', '1996-07-26', NULL);

