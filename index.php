<?php require_once __DIR__ . '/backend.php'; ?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ToDoList</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
      <span class="navbar-brand mb-0 h1">ToDoList</span>
    </div>
  </nav>
  <div class="container" style="max-width: 720px;">
    <form method="post" class="input-group mb-4">
      <input type="hidden" name="action" value="new">
      <input type="text" name="title" class="form-control"
             placeholder="Nouvelle tâche..." required maxlength="2048">
      <button type="submit" class="btn btn-primary">Add</button>
    </form>
    <div id="root"></div>
  </div>
  <script>
    const taches = <?= json_encode($taches, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
  <script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
  <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
  <script type="text/babel">
    function ActionButton({ action, id, className, children }) {
      return (
        <form method="post" className="d-inline">
          <input type="hidden" name="action" value={action} />
          <input type="hidden" name="id" value={id} />
          <button type="submit" className={className}>{children}</button>
        </form>
      );
    }
    function TodoItem({ tache }) {
      const done = Number(tache.done) === 1;
      const itemClass = done ? "list-group-item-success" : "list-group-item-warning";
      return (
        <li className={"list-group-item d-flex justify-content-between align-items-center " + itemClass}>
          <span style={{ textDecoration: done ? "line-through" : "none" }}>
            {tache.title}
          </span>
          <span className="d-flex gap-2">
            <ActionButton action="toggle" id={tache.id} className="btn btn-sm btn-outline-success">
              {done ? "Undo" : "Done"}
            </ActionButton>
            <ActionButton action="delete" id={tache.id} className="btn btn-sm btn-outline-danger">
              X
            </ActionButton>
          </span>
        </li>
      );
    }
    function TodoList({ taches }) {
      if (taches.length === 0) {
        return <p className="text-center text-muted">Aucune tâche pour le moment.</p>;
      }
      return (
        <ul className="list-group shadow-sm">
          {taches.map(t => <TodoItem key={t.id} tache={t} />)}
        </ul>
      );
    }
    ReactDOM.createRoot(document.getElementById("root")).render(<TodoList taches={taches} />);
  </script>
</body>
</html>
