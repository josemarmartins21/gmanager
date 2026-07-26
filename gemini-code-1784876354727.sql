CREATE DATABASE IF NOT EXISTS bar_management_db 
DEFAULT CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE bar_management_db;

-- -----------------------------------------------------
-- 1. Tabela: Categorias
-- -----------------------------------------------------
CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- 2. Tabela: Produtos
-- -----------------------------------------------------
CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(100) NOT NULL,
    sale_price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    
    -- Unidades contidas numa caixa/volume padrão (ex: 24 para cerveja, 10 para tabaco)
    units_per_box INT UNSIGNED NOT NULL DEFAULT 1,
    
    -- Stock gerido sempre na unidade mínima (ex: garrafas soltas, maços soltos)
    current_stock INT NOT NULL DEFAULT 0,
    min_stock_alert INT UNSIGNED NOT NULL DEFAULT 10,
    
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- 3. Tabela: Vendas (Cabeçalho)
-- -----------------------------------------------------
CREATE TABLE sales (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    total_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- 4. Tabela: Itens da Venda (Detalhe)
-- -----------------------------------------------------
CREATE TABLE sale_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    sale_id INT UNSIGNED NOT NULL,
    product_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED NOT NULL,
    unit_price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- 5. Tabela: Movimentos de Stock (Entradas e Ajustes)
-- -----------------------------------------------------
CREATE TABLE stock_movements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    product_id INT UNSIGNED NOT NULL,
    
    -- IN: Entrada de mercadoria | LOSS: Garrafa partida/Avaria | ADJUSTMENT: Correção de inventário
    type ENUM('IN', 'LOSS', 'ADJUSTMENT') NOT NULL,
    
    boxes_qty INT UNSIGNED DEFAULT 0,         -- Quantidade de caixas inseridas
    units_per_box INT UNSIGNED DEFAULT 1,     -- Rácio de conversão usado na entrada
    total_units INT NOT NULL,                 -- Total de unidades movimentadas (calculado)
    
    notes VARCHAR(255) NULL,                  -- Motivo ou observação
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
) ENGINE=InnoDB;