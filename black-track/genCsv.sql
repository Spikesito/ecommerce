SELECT DISTINCT 
product.ProductId, product.Name AS ProductName, category.Name AS CategoryName, product.Price, product.Supplier ,product.CreationDate, invoices.CustomerId AS CustomerId, invoices.Quantity AS Quantity, rate.Rate, invoices.InvoiceDate, invoices.InvoiceId
FROM product
INNER JOIN invoices ON product.ProductId = invoices.ProductId
INNER JOIN command ON command.CustomerId = invoices.CustomerId
INNER JOIN rate ON product.ProductId = rate.ProductId
INNER JOIN category ON product.CategoryId = category.CategoryId
ORDER BY invoices.ProductId