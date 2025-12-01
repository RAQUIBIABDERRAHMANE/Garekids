<?php require_once 'header.php'; 

// Handle user deletion
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Prevent deleting your own account
    if ($id !== $_SESSION['user_id']) {
        if (isset($pdo)) {
            $stmt = $pdo->prepare('DELETE FROM users WHERE id = ?');
            $stmt->execute([$id]);
        } elseif (isset($conn)) {
            $stmt = $conn->prepare('DELETE FROM users WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
        $success_message = $_SESSION['lang'] === 'fr' ? 'Utilisateur supprimé avec succès' : 'User deleted successfully';
    } else {
        $error_message = $_SESSION['lang'] === 'fr' ? 'Vous ne pouvez pas supprimer votre propre compte' : 'You cannot delete your own account';
    }
}

// Handle admin toggle
if (isset($_GET['action']) && $_GET['action'] === 'toggle_admin' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Prevent removing your own admin status
    if ($id !== $_SESSION['user_id']) {
        if (isset($pdo)) {
            $stmt = $pdo->prepare('UPDATE users SET is_admin = NOT is_admin WHERE id = ?');
            $stmt->execute([$id]);
        } elseif (isset($conn)) {
            $stmt = $conn->prepare('UPDATE users SET is_admin = NOT is_admin WHERE id = ?');
            $stmt->bind_param('i', $id);
            $stmt->execute();
        }
        $success_message = $_SESSION['lang'] === 'fr' ? 'Statut administrateur modifié' : 'Admin status updated';
    } else {
        $error_message = $_SESSION['lang'] === 'fr' ? 'Vous ne pouvez pas modifier votre propre statut' : 'You cannot modify your own status';
    }
}

// Get all users
$users = [];
if (isset($pdo)) {
    $users = $pdo->query('SELECT id, name, email, is_admin, created_at FROM users ORDER BY created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
} elseif (isset($conn)) {
    $result = $conn->query('SELECT id, name, email, is_admin, created_at FROM users ORDER BY created_at DESC');
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<div class="mb-6">
  <h2 class="text-3xl font-bold text-gray-800"><?php echo $_SESSION['lang'] === 'fr' ? 'Gestion des utilisateurs' : 'User Management'; ?></h2>
  <p class="text-gray-600"><?php echo $_SESSION['lang'] === 'fr' ? 'Voir et gérer tous les utilisateurs inscrits' : 'View and manage all registered users'; ?></p>
</div>

<?php if (isset($success_message)): ?>
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
  <?php echo $success_message; ?>
</div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
  <?php echo $error_message; ?>
</div>
<?php endif; ?>

<div class="bg-white rounded-lg shadow-lg overflow-hidden">
  <div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-gradient-to-r from-amber-500 to-amber-600">
        <tr>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Nom' : 'Name'; ?>
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            Email
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Statut' : 'Status'; ?>
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Date d\'inscription' : 'Registered Date'; ?>
          </th>
          <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
            Actions
          </th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-200">
        <?php if (empty($users)): ?>
        <tr>
          <td colspan="5" class="px-6 py-8 text-center text-gray-500">
            <?php echo $_SESSION['lang'] === 'fr' ? 'Aucun utilisateur trouvé' : 'No users found'; ?>
          </td>
        </tr>
        <?php else: ?>
          <?php foreach ($users as $user): ?>
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center">
                <div class="flex-shrink-0 h-10 w-10">
                  <div class="h-10 w-10 rounded-full bg-amber-100 flex items-center justify-center">
                    <i class="fas fa-user text-amber-600"></i>
                  </div>
                </div>
                <div class="ml-4">
                  <div class="text-sm font-medium text-gray-900">
                    <?php echo htmlspecialchars($user['name']); ?>
                    <?php if ($user['id'] == $_SESSION['user_id']): ?>
                      <span class="ml-2 text-xs text-amber-600">(<?php echo $_SESSION['lang'] === 'fr' ? 'Vous' : 'You'; ?>)</span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm text-gray-900"><?php echo htmlspecialchars($user['email']); ?></div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <?php if ($user['is_admin']): ?>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">
                  <i class="fas fa-crown mr-1"></i>
                  <?php echo $_SESSION['lang'] === 'fr' ? 'Administrateur' : 'Admin'; ?>
                </span>
              <?php else: ?>
                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                  <i class="fas fa-user mr-1"></i>
                  <?php echo $_SESSION['lang'] === 'fr' ? 'Utilisateur' : 'User'; ?>
                </span>
              <?php endif; ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
              <?php echo date('M d, Y', strtotime($user['created_at'])); ?>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <div class="flex gap-2">
                <?php if ($user['id'] != $_SESSION['user_id']): ?>
                  <a href="?action=toggle_admin&id=<?php echo $user['id']; ?>" 
                     onclick="return confirm('<?php echo $_SESSION['lang'] === 'fr' ? 'Êtes-vous sûr de vouloir modifier le statut administrateur ?' : 'Are you sure you want to toggle admin status?'; ?>')"
                     class="text-blue-600 hover:text-blue-900 transition-colors" 
                     title="<?php echo $_SESSION['lang'] === 'fr' ? 'Basculer admin' : 'Toggle Admin'; ?>">
                    <i class="fas fa-user-shield"></i>
                  </a>
                  <a href="?action=delete&id=<?php echo $user['id']; ?>" 
                     onclick="return confirm('<?php echo $_SESSION['lang'] === 'fr' ? 'Êtes-vous sûr de vouloir supprimer cet utilisateur ?' : 'Are you sure you want to delete this user?'; ?>')"
                     class="text-red-600 hover:text-red-900 transition-colors" 
                     title="<?php echo $_SESSION['lang'] === 'fr' ? 'Supprimer' : 'Delete'; ?>">
                    <i class="fas fa-trash"></i>
                  </a>
                <?php else: ?>
                  <span class="text-gray-400">-</span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
  <div class="flex items-start">
    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
    <div class="text-sm text-blue-800">
      <p class="font-semibold mb-1"><?php echo $_SESSION['lang'] === 'fr' ? 'Informations' : 'Information'; ?>:</p>
      <ul class="list-disc list-inside space-y-1">
        <li><?php echo $_SESSION['lang'] === 'fr' ? 'Vous ne pouvez pas supprimer ou modifier votre propre compte' : 'You cannot delete or modify your own account'; ?></li>
        <li><?php echo $_SESSION['lang'] === 'fr' ? 'Cliquez sur l\'icône de bouclier pour basculer le statut administrateur' : 'Click the shield icon to toggle admin status'; ?></li>
        <li><?php echo $_SESSION['lang'] === 'fr' ? 'Les administrateurs ont accès au panneau d\'administration' : 'Admins have access to the admin panel'; ?></li>
      </ul>
    </div>
  </div>
</div>

<?php require_once 'footer.php'; ?>
