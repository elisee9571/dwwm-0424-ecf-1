# Qu'est-ce qu'une transaction ?

Une transaction est une séquence d'opérations de base de données qui sont exécutées comme une seule unité logique de travail. Une transaction doit respecter quatre propriétés fondamentales, souvent résumées par l'acronyme ACID :

## Atomicité (Atomicity)

- La transaction est indivisible : toutes les opérations réussissent ou échouent ensemble. Si une partie de la transaction échoue, toutes les modifications apportées à la base de données par cette transaction sont annulées.

## Cohérence (Consistency)

- Une transaction doit transformer la base de données d'un état valide à un autre état valide. Elle doit préserver l'intégrité de la base de données en respectant toutes les contraintes et règles définies.

## Isolation (Isolation)

- Les opérations de différentes transactions doivent être isolées les unes des autres. Cela signifie que les modifications effectuées par une transaction ne sont pas visibles par les autres transactions jusqu'à ce que la transaction soit validée (committed).

## Durabilité (Durability)

- Une fois qu'une transaction est validée, ses modifications sont permanentes, même en cas de panne système. Les données validées doivent être correctement enregistrées sur un support de stockage permanent.

# Cycle de vie d'une transaction

## Début de la transaction

- Une transaction commence explicitement avec une commande comme `BEGIN TRANSACTION` ou implicitement par certaines opérations de base de données.

## Exécution des opérations

- Toutes les opérations (`INSERT`, `UPDATE`, `DELETE`, etc.) sont exécutées dans le cadre de la transaction.

## Validation (COMMIT)

- Si toutes les opérations réussissent, la transaction est validée avec une commande `COMMIT`. Les modifications apportées sont alors enregistrées de manière permanente.

## Annulation (ROLLBACK)

- Si une opération échoue ou si une condition d'erreur se produit, la transaction peut être annulée avec une commande `ROLLBACK`. Toutes les modifications apportées par la transaction sont annulées, et la base de données est restaurée à son état initial avant le début de la transaction.

# Pourquoi les transactions sont importantes

## Assurance de l'intégrité des données :

- Les transactions garantissent que la base de données reste dans un état cohérent et valide, même en cas de défaillance système ou d'erreurs d'application.

## Gestion des pannes :

- En cas de panne, les transactions permettent de récupérer la base de données à un état cohérent connu grâce aux propriétés d'atomicité et de durabilité.

# Exemple d'utilisation de transactions en PHP

```php
try {
    $this->pdo->beginTransaction();
    
    $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$userId, $total]);
    $orderId = $this->pdo->lastInsertId();

    $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($products as $product) {
        $stmt->execute([$orderId, $product['id'], $cart[$product['id']], $product['price']]);
    }

    $this->pdo->commit();

    unset($_SESSION['cart']);
    header('Location: /order/success');
} catch (\Exception $e) {
    $this->pdo->rollBack();
    echo "Erreur lors de la commande: " . $e->getMessage();
}
```

# Injection SQL et Prévention
Le code montre une approche sûre contre les injections SQL principalement grâce à l'utilisation de requêtes préparées `prepare()` et `execute()` pour toutes les interactions avec la base de données.
