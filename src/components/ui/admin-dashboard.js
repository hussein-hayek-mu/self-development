// ========================================
// ADMIN DASHBOARD JAVASCRIPT
// Handles all admin-specific functionality
// ========================================

// ========================================
// DATA & STATE
// ========================================

let currentSection = "dashboard";
let currentPage = 1;
const usersPerPage = 10;
let allUsers = [];
let filteredUsers = [];

// Sample Users Data
const usersData = [
  {
    id: 1,
    name: "John Warrior",
    email: "john@example.com",
    role: "user",
    level: 15,
    xp: 8540,
    status: "active",
    joined: "2024-11-15",
    avatar: "https://i.pravatar.cc/150?img=1",
  },
  {
    id: 2,
    name: "Sarah Mage",
    email: "sarah@example.com",
    role: "user",
    level: 22,
    xp: 15240,
    status: "active",
    joined: "2024-10-20",
    avatar: "https://i.pravatar.cc/150?img=5",
  },
  {
    id: 3,
    name: "Mike Admin",
    email: "mike@example.com",
    role: "admin",
    level: 30,
    xp: 25000,
    status: "active",
    joined: "2024-08-10",
    avatar: "https://i.pravatar.cc/150?img=11",
  },
  {
    id: 4,
    name: "Emma Knight",
    email: "emma@example.com",
    role: "user",
    level: 18,
    xp: 11500,
    status: "active",
    joined: "2024-12-01",
    avatar: "https://i.pravatar.cc/150?img=9",
  },
  {
    id: 5,
    name: "Tom Archer",
    email: "tom@example.com",
    role: "user",
    level: 12,
    xp: 6200,
    status: "inactive",
    joined: "2024-09-15",
    avatar: "https://i.pravatar.cc/150?img=7",
  },
  {
    id: 6,
    name: "Lisa Paladin",
    email: "lisa@example.com",
    role: "user",
    level: 25,
    xp: 18900,
    status: "active",
    joined: "2024-11-28",
    avatar: "https://i.pravatar.cc/150?img=16",
  },
  {
    id: 7,
    name: "David Rogue",
    email: "david@example.com",
    role: "user",
    level: 20,
    xp: 13400,
    status: "active",
    joined: "2024-10-05",
    avatar: "https://i.pravatar.cc/150?img=13",
  },
  {
    id: 8,
    name: "Anna Healer",
    email: "anna@example.com",
    role: "user",
    level: 16,
    xp: 9100,
    status: "active",
    joined: "2024-12-10",
    avatar: "https://i.pravatar.cc/150?img=21",
  },
];

// Sample Recent Activity Data
const recentActivity = [
  {
    icon: "👤",
    title: "New User Registration",
    description: "Sarah Mage joined the platform",
    time: "5 min ago",
    type: "user",
  },
  {
    icon: "🎯",
    title: "Quest Completed",
    description: 'John Warrior completed "Morning Meditation"',
    time: "12 min ago",
    type: "quest",
  },
  {
    icon: "⚡",
    title: "Level Up",
    description: "Emma Knight reached Level 18",
    time: "25 min ago",
    type: "level",
  },
  {
    icon: "🏆",
    title: "Badge Earned",
    description: 'Tom Archer earned "Consistency Master" badge',
    time: "1 hour ago",
    type: "badge",
  },
  {
    icon: "🔥",
    title: "Streak Milestone",
    description: "Lisa Paladin achieved 30 day streak",
    time: "2 hours ago",
    type: "streak",
  },
];

// ========================================
// INITIALIZATION
// ========================================

document.addEventListener("DOMContentLoaded", () => {
  initializeApp();
});

function initializeApp() {
  allUsers = [...usersData];
  filteredUsers = [...allUsers];

  renderUsersTable();
  renderPagination();
  renderRecentActivity();

  // Initialize charts (placeholder)
  console.log("Charts would be initialized here with a library like Chart.js");
}

// ========================================
// NAVIGATION
// ========================================

function showSection(sectionId) {
  // Update content sections
  document.querySelectorAll(".content-section").forEach((section) => {
    section.classList.remove("active");
  });
  document.getElementById(sectionId)?.classList.add("active");

  // Update navigation items
  document.querySelectorAll(".nav-item").forEach((item) => {
    item.classList.remove("active");
  });
  event.target.closest(".nav-item")?.classList.add("active");

  // Update page title
  const titles = {
    dashboard: "Dashboard Overview",
    users: "User Management",
    content: "Content Management",
    analytics: "Analytics & Reports",
    "my-profile": "My Profile",
    settings: "System Settings",
  };

  document.getElementById("pageTitle").textContent =
    titles[sectionId] || "Dashboard";
  currentSection = sectionId;

  // Close mobile sidebar if open
  closeMobileSidebar();
}

function toggleSidebar() {
  const sidebar = document.querySelector(".admin-sidebar");
  const main = document.querySelector(".admin-main");

  sidebar.classList.toggle("mobile-open");
}

function closeMobileSidebar() {
  const sidebar = document.querySelector(".admin-sidebar");
  if (window.innerWidth <= 1024) {
    sidebar.classList.remove("mobile-open");
  }
}

function logout() {
  if (confirm("Are you sure you want to logout?")) {
    alert("Logout functionality would redirect to login page");
    // In real app: window.location.href = '/logout';
  }
}

// ========================================
// USERS MANAGEMENT
// ========================================

function renderUsersTable() {
  const tbody = document.getElementById("usersTableBody");
  const start = (currentPage - 1) * usersPerPage;
  const end = start + usersPerPage;
  const pageUsers = filteredUsers.slice(start, end);

  tbody.innerHTML = pageUsers
    .map(
      (user) => `
    <tr>
      <td>
        <div class="user-cell">
          <img src="${user.avatar}" alt="${user.name}" class="user-avatar">
          <div>
            <div class="user-info-name">${user.name}</div>
            <div class="user-info-email">${user.email}</div>
          </div>
        </div>
      </td>
      <td>${user.email}</td>
      <td><span class="role-badge ${
        user.role
      }">${user.role.toUpperCase()}</span></td>
      <td>${user.level}</td>
      <td>${user.xp.toLocaleString()} XP</td>
      <td><span class="status-badge ${user.status}">${
        user.status.charAt(0).toUpperCase() + user.status.slice(1)
      }</span></td>
      <td>${formatDate(user.joined)}</td>
      <td>
        <div class="action-btns">
          <button class="action-btn" onclick="editUser(${
            user.id
          })" title="Edit">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
              <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
          </button>
          <button class="action-btn" onclick="toggleUserStatus(${
            user.id
          })" title="Toggle Status">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              ${
                user.status === "active"
                  ? '<path d="M18 6L6 18M6 6l12 12"/>'
                  : '<polyline points="20 6 9 17 4 12"/>'
              }
            </svg>
          </button>
          <button class="action-btn" onclick="deleteUser(${
            user.id
          })" title="Delete">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <polyline points="3 6 5 6 21 6"/>
              <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
              <line x1="10" y1="11" x2="10" y2="17"/>
              <line x1="14" y1="11" x2="14" y2="17"/>
            </svg>
          </button>
        </div>
      </td>
    </tr>
  `
    )
    .join("");
}

function filterUsers() {
  const searchTerm = document.getElementById("userSearch").value.toLowerCase();
  const roleFilter = document.getElementById("roleFilter").value;
  const statusFilter = document.getElementById("statusFilter").value;

  filteredUsers = allUsers.filter((user) => {
    const matchesSearch =
      user.name.toLowerCase().includes(searchTerm) ||
      user.email.toLowerCase().includes(searchTerm);
    const matchesRole = !roleFilter || user.role === roleFilter;
    const matchesStatus = !statusFilter || user.status === statusFilter;

    return matchesSearch && matchesRole && matchesStatus;
  });

  currentPage = 1;
  renderUsersTable();
  renderPagination();
}

function editUser(userId) {
  const user = allUsers.find((u) => u.id === userId);
  if (!user) return;

  // Populate modal
  document.getElementById("editUserName").value = user.name;
  document.getElementById("editUserEmail").value = user.email;
  document.getElementById("editUserRole").value = user.role;
  document.getElementById("editUserStatus").value = user.status;

  // Show modal
  document.getElementById("editUserModal").classList.add("active");

  // Store current user ID for saving
  window.currentEditUserId = userId;
}

function saveUser() {
  const userId = window.currentEditUserId;
  const user = allUsers.find((u) => u.id === userId);

  if (user) {
    user.name = document.getElementById("editUserName").value;
    user.email = document.getElementById("editUserEmail").value;
    user.role = document.getElementById("editUserRole").value;
    user.status = document.getElementById("editUserStatus").value;

    renderUsersTable();
    closeModal("editUserModal");

    showNotification("User updated successfully!", "success");
  }
}

function toggleUserStatus(userId) {
  const user = allUsers.find((u) => u.id === userId);
  if (user) {
    user.status = user.status === "active" ? "inactive" : "active";
    renderUsersTable();
    showNotification(
      `User ${user.status === "active" ? "activated" : "deactivated"}`,
      "success"
    );
  }
}

function deleteUser(userId) {
  if (
    confirm(
      "Are you sure you want to delete this user? This action cannot be undone."
    )
  ) {
    const index = allUsers.findIndex((u) => u.id === userId);
    if (index !== -1) {
      allUsers.splice(index, 1);
      filteredUsers = [...allUsers];
      renderUsersTable();
      renderPagination();
      showNotification("User deleted successfully", "success");
    }
  }
}

function showAddUserModal() {
  alert("Add User modal would open here");
  // In real implementation, show a modal similar to editUserModal
}

// ========================================
// PAGINATION
// ========================================

function renderPagination() {
  const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
  const paginationNumbers = document.getElementById("paginationNumbers");

  paginationNumbers.innerHTML = "";

  for (let i = 1; i <= totalPages; i++) {
    const pageBtn = document.createElement("div");
    pageBtn.className = "page-number" + (i === currentPage ? " active" : "");
    pageBtn.textContent = i;
    pageBtn.onclick = () => goToPage(i);
    paginationNumbers.appendChild(pageBtn);
  }
}

function goToPage(page) {
  const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
  if (page >= 1 && page <= totalPages) {
    currentPage = page;
    renderUsersTable();
    renderPagination();
  }
}

function previousPage() {
  if (currentPage > 1) {
    goToPage(currentPage - 1);
  }
}

function nextPage() {
  const totalPages = Math.ceil(filteredUsers.length / usersPerPage);
  if (currentPage < totalPages) {
    goToPage(currentPage + 1);
  }
}

// ========================================
// CONTENT MANAGEMENT
// ========================================

function switchContentTab(tabName) {
  // Update tab buttons
  document.querySelectorAll(".content-tab").forEach((tab) => {
    tab.classList.remove("active");
  });
  event.target.classList.add("active");

  // Update tab panels
  document.querySelectorAll(".content-tab-panel").forEach((panel) => {
    panel.classList.remove("active");
  });
  document.getElementById(tabName + "Content")?.classList.add("active");
}

// ========================================
// RECENT ACTIVITY
// ========================================

function renderRecentActivity() {
  const activityList = document.getElementById("recentActivity");

  activityList.innerHTML = recentActivity
    .map(
      (activity) => `
    <div class="activity-item">
      <div class="activity-icon">${activity.icon}</div>
      <div class="activity-content">
        <div class="activity-title">${activity.title}</div>
        <div class="activity-description">${activity.description}</div>
      </div>
      <div class="activity-time">${activity.time}</div>
    </div>
  `
    )
    .join("");
}

// ========================================
// MODALS
// ========================================

function closeModal(modalId) {
  document.getElementById(modalId).classList.remove("active");
}

// Close modal when clicking outside
document.addEventListener("click", (e) => {
  if (e.target.classList.contains("modal")) {
    e.target.classList.remove("active");
  }
});

// ========================================
// UTILITY FUNCTIONS
// ========================================

function formatDate(dateString) {
  const date = new Date(dateString);
  const options = { year: "numeric", month: "short", day: "numeric" };
  return date.toLocaleDateString("en-US", options);
}

function showNotification(message, type = "info") {
  // Simple notification (in real app, use a proper notification library)
  const notification = document.createElement("div");
  notification.style.cssText = `
    position: fixed;
    top: 2rem;
    right: 2rem;
    padding: 1rem 1.5rem;
    background: ${type === "success" ? "#22c55e" : "#3b82f6"};
    color: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    z-index: 3000;
    animation: slideIn 0.3s ease-out;
    font-weight: 600;
  `;
  notification.textContent = message;

  document.body.appendChild(notification);

  setTimeout(() => {
    notification.style.animation = "slideOut 0.3s ease-out";
    setTimeout(() => notification.remove(), 300);
  }, 3000);
}

// ========================================
// CHARTS (Placeholder)
// ========================================

// In a real implementation, you would initialize Chart.js or similar here
function initializeCharts() {
  // Example with Chart.js:
  /*
  const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
  new Chart(userGrowthCtx, {
    type: 'line',
    data: {
      labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
      datasets: [{
        label: 'New Users',
        data: [12, 19, 15, 25, 22, 30, 28],
        borderColor: '#a855f7',
        tension: 0.4
      }]
    }
  });
  */
}

// ========================================
// KEYBOARD SHORTCUTS
// ========================================

document.addEventListener("keydown", (e) => {
  // Escape key closes modals
  if (e.key === "Escape") {
    document.querySelectorAll(".modal.active").forEach((modal) => {
      modal.classList.remove("active");
    });
  }

  // Ctrl/Cmd + K for search
  if ((e.ctrlKey || e.metaKey) && e.key === "k") {
    e.preventDefault();
    document.getElementById("userSearch")?.focus();
  }
});

// ========================================
// RESPONSIVE HANDLERS
// ========================================

window.addEventListener("resize", () => {
  if (window.innerWidth > 1024) {
    document.querySelector(".admin-sidebar")?.classList.remove("mobile-open");
  }
});

// Close sidebar when clicking outside on mobile
document.addEventListener("click", (e) => {
  const sidebar = document.querySelector(".admin-sidebar");
  const menuToggle = document.querySelector(".menu-toggle");

  if (
    window.innerWidth <= 1024 &&
    sidebar?.classList.contains("mobile-open") &&
    !sidebar.contains(e.target) &&
    !menuToggle.contains(e.target)
  ) {
    sidebar.classList.remove("mobile-open");
  }
});

// ========================================
// EXPORT FUNCTIONS (Make available globally)
// ========================================

window.showSection = showSection;
window.toggleSidebar = toggleSidebar;
window.logout = logout;
window.editUser = editUser;
window.saveUser = saveUser;
window.toggleUserStatus = toggleUserStatus;
window.deleteUser = deleteUser;
window.showAddUserModal = showAddUserModal;
window.filterUsers = filterUsers;
window.previousPage = previousPage;
window.nextPage = nextPage;
window.goToPage = goToPage;
window.switchContentTab = switchContentTab;
window.closeModal = closeModal;

console.log("✅ Admin Dashboard initialized successfully");
