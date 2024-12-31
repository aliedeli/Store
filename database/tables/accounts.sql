CREATE TABLE Accounts (
    account_id INT PRIMARY KEY IDENTITY(1,1),
    account_name VARCHAR(100) NOT NULL,
    account_type VARCHAR(50),
    balance DECIMAL(18,2) DEFAULT 0.00,
    created_at DATETIME DEFAULT GETDATE(),
    updated_at DATETIME DEFAULT GETDATE()
);

CREATE TABLE Orders (
    order_id INT PRIMARY KEY IDENTITY(1,1),
    account_id INT,
    order_amount DECIMAL(18,2),
    order_date DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id)
);

CREATE TABLE AccountTransactions (
    transaction_id INT PRIMARY KEY IDENTITY(1,1),
    account_id INT,
    order_id INT NULL,
    transaction_type VARCHAR(20),
    amount DECIMAL(18,2),
    transaction_date DATETIME DEFAULT GETDATE(),
    FOREIGN KEY (account_id) REFERENCES Accounts(account_id),
    FOREIGN KEY (order_id) REFERENCES Orders(order_id)
);
