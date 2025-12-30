// --- DATA & LOGIC ---
const userData = {
  level: 12,
  xp: 7540,
  xp_to_next: 10000,
  total_xp: 15000,
  current_streak: 5,
  longest_streak: 12,
  rank_title: "Focused Strategist",
};

let quests = {
  daily: [
    {
      id: 1,
      title: "Morning Meditation",
      description: "Start your day mindfully",
      type: "daily",
      difficulty: "easy",
      xp_reward: 50,
      status: "active",
      due_date: null,
    },
    {
      id: 2,
      title: "Read 30 Pages",
      description: "Learn something new",
      type: "daily",
      difficulty: "easy",
      xp_reward: 100,
      status: "active",
      due_date: null,
    },
    {
      id: 3,
      title: "Workout Session",
      description: "Stay healthy and strong",
      type: "daily",
      difficulty: "medium",
      xp_reward: 150,
      status: "active",
      due_date: null,
    },
  ],
  weekly: [
    {
      id: 4,
      title: "Complete Side Project Milestone",
      description: "Make progress on personal project",
      type: "weekly",
      difficulty: "medium",
      xp_reward: 500,
      status: "active",
      due_date: "2025-01-05",
    },
  ],
  boss: [
    {
      id: 6,
      title: "Launch Your Product",
      description: "Ship your MVP to users",
      type: "boss",
      difficulty: "hard",
      xp_reward: 2000,
      status: "active",
      due_date: "2025-01-15",
    },
  ],
};

let habits = [
  {
    id: 1,
    title: "Morning Exercise",
    description: "Daily workout routine",
    xp_reward: 50,
    current_streak: 7,
    best_streak: 10,
    frequency: "daily",
    is_active: true,
    completed_today: false,
  },
  {
    id: 2,
    title: "Gratitude Journal",
    description: "Write 3 things you're grateful for",
    xp_reward: 30,
    current_streak: 12,
    best_streak: 15,
    frequency: "daily",
    is_active: true,
    completed_today: false,
  },
  {
    id: 3,
    title: "No Social Media",
    description: "Avoid social media for the day",
    xp_reward: 40,
    current_streak: 5,
    best_streak: 8,
    frequency: "daily",
    is_active: true,
    completed_today: false,
  },
];

// --- AUTH ---
function switchAuthTab(tab) {
  document
    .querySelectorAll(".auth-tab")
    .forEach((t) => t.classList.remove("active"));
  document
    .querySelectorAll(".auth-form")
    .forEach((f) => f.classList.remove("active"));
  if (tab === "login") {
    document.querySelector(".auth-tab:first-child").classList.add("active");
    document.getElementById("loginForm").classList.add("active");
  } else {
    document.querySelector(".auth-tab:last-child").classList.add("active");
    document.getElementById("registerForm").classList.add("active");
  }
}

function simulateLogin() {
  document.getElementById("authScreen").classList.add("hidden");
  document.getElementById("appContainer").style.display = "flex";
  setTimeout(() => {
    document.getElementById("appContainer").classList.add("visible");
    // Auto-navigate to landing/home page instead of dashboard
    navigateTo("landing");
  }, 100);
}

function logout() {
  document.getElementById("appContainer").classList.remove("visible");
  setTimeout(() => {
    document.getElementById("appContainer").style.display = "none";
    document.getElementById("authScreen").classList.remove("hidden");
  }, 500);
}

// --- NAVIGATION ---
function navigateTo(pageName) {
  document
    .querySelectorAll(".page")
    .forEach((p) => p.classList.remove("active"));
  document
    .querySelectorAll(".nav-item")
    .forEach((i) => i.classList.remove("active"));
  document.getElementById(`page-${pageName}`).classList.add("active");
  const nav = document.querySelector(`[data-page="${pageName}"]`);
  if (nav) nav.classList.add("active");

  const sb = document.getElementById("sidebar");
  const mc = document.getElementById("mainContent");
  if (pageName !== "landing") {
    sb.classList.add("active");
    mc.classList.add("with-sidebar");
  } else {
    sb.classList.remove("active");
    mc.classList.remove("with-sidebar");
  }
}

function startJourney() {
  navigateTo("dashboard");
  setTimeout(() => {
    document.getElementById("dashboardXpBar").style.width = "75%";
  }, 100);
}

// --- RENDERING ---
function renderQuests(questArray, containerId, category) {
  const container = document.getElementById(containerId);
  container.innerHTML = questArray
    .map((quest) => {
      const isCompleted = quest.status === "completed";
      const timeDisplay = quest.due_date
        ? new Date(quest.due_date).toLocaleDateString()
        : "No deadline";

      return `
                <div class="quest-card ${isCompleted ? "completed" : ""}">
                    <!-- Check Circle Toggle -->
                    <div class="check-circle ${isCompleted ? "completed" : ""}" 
                         onclick="toggleQuest(${quest.id}, '${category}')">
                         ${isCompleted ? "✓" : ""}
                    </div>

                    <div class="card-content">
                        <div class="quest-header-row">
                            <div class="quest-title">${quest.title}</div>
                            <div class="quest-xp-badge">+${
                              quest.xp_reward
                            } XP</div>
                        </div>
                        <div class="quest-meta-row">
                            <span class="difficulty difficulty-${
                              quest.difficulty
                            }">${quest.difficulty.toUpperCase()}</span>
                            <span>📅 ${timeDisplay}</span>
                            <div class="card-actions">
                                <span class="action-icon" onclick="openQuestModal(${
                                  quest.id
                                }, '${category}')">✏️</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
    })
    .join("");
}

function refreshAllQuests() {
  renderQuests(quests.daily, "dashboardQuests", "daily");
  renderQuests(quests.daily, "dailyQuests", "daily");
  renderQuests(quests.weekly, "weeklyQuests", "weekly");
  renderQuests(quests.boss, "bossQuests", "boss");
}

function renderHabits() {
  const container = document.getElementById("habitsList");
  container.innerHTML = habits
    .map(
      (habit) => `
                <div class="habit-card ${
                  habit.completed_today ? "completed" : ""
                }">
                    <div class="habit-toggle ${
                      habit.completed_today ? "completed" : ""
                    }" onclick="toggleHabit(${habit.id})"></div>
                    <div class="card-content">
                        <div class="quest-title">${habit.title}</div>
                        <div class="quest-meta-row" style="margin-top: 5px;">
                            <span style="color: var(--accent-gold); font-weight:600;">🔥 ${
                              habit.current_streak
                            } day streak</span>
                            <span>+${habit.xp_reward} XP</span>
                            <div class="card-actions">
                                <span class="action-icon" onclick="openHabitModal(${
                                  habit.id
                                })">✏️</span>
                            </div>
                        </div>
                    </div>
                </div>
            `
    )
    .join("");
}

// --- ACTIONS ---
function toggleQuest(id, category) {
  const quest = quests[category].find((q) => q.id === id);
  const wasCompleted = quest.status === "completed";

  quest.status = wasCompleted ? "active" : "completed";

  if (!wasCompleted) {
    userData.xp += quest.xp_reward;
    userData.total_xp += quest.xp_reward;
    updateXP();
  } else {
    userData.xp -= quest.xp_reward;
    userData.total_xp -= quest.xp_reward;
    updateXP();
  }
  refreshAllQuests();
}

function toggleHabit(id) {
  const habit = habits.find((h) => h.id === id);
  habit.completed_today = !habit.completed_today;

  if (habit.completed_today) {
    habit.current_streak++;
    if (habit.current_streak > habit.best_streak) {
      habit.best_streak = habit.current_streak;
    }
    userData.xp += habit.xp_reward;
    userData.total_xp += habit.xp_reward;
  } else {
    habit.current_streak = Math.max(0, habit.current_streak - 1);
    userData.xp -= habit.xp_reward;
    userData.total_xp -= habit.xp_reward;
  }

  renderHabits();
  updateXP();

  const allCompleted = habits.every((h) => h.completed_today);
  const bonusDiv = document.getElementById("perfectDayBonus");
  bonusDiv.style.display = allCompleted ? "block" : "none";
}

// --- MODALS (CRUD) ---
function closeModal(modalId) {
  document.getElementById(modalId).classList.remove("active");
}

// Habit CRUD
function openHabitModal(id = null) {
  const modal = document.getElementById("habitModal");
  const deleteBtn = document.getElementById("deleteHabitBtn");
  if (id) {
    const habit = habits.find((h) => h.id === id);
    document.getElementById("habitModalTitle").textContent = "Edit Habit";
    document.getElementById("habitId").value = habit.id;
    document.getElementById("habitTitle").value = habit.title;
    document.getElementById("habitXp").value = habit.xp_reward;
    deleteBtn.style.display = "block";
  } else {
    document.getElementById("habitModalTitle").textContent = "Add New Habit";
    document.getElementById("habitId").value = "";
    document.getElementById("habitTitle").value = "";
    document.getElementById("habitXp").value = 50;
    deleteBtn.style.display = "none";
  }
  modal.classList.add("active");
}

function saveHabit() {
  const id = document.getElementById("habitId").value;
  const title = document.getElementById("habitTitle").value;
  const xp_reward = parseInt(document.getElementById("habitXp").value);
  if (!title) return alert("Title required");

  if (id) {
    const habit = habits.find((h) => h.id == id);
    habit.title = title;
    habit.xp_reward = xp_reward;
  } else {
    habits.push({
      id: Date.now(),
      title,
      description: "",
      current_streak: 0,
      best_streak: 0,
      xp_reward,
      frequency: "daily",
      is_active: true,
      completed_today: false,
    });
  }
  renderHabits();
  closeModal("habitModal");
}

function deleteHabit() {
  if (confirm("Delete habit?")) {
    habits = habits.filter(
      (h) => h.id != document.getElementById("habitId").value
    );
    renderHabits();
    closeModal("habitModal");
  }
}

// Quest CRUD
function openQuestModal(id = null, category = "daily") {
  const modal = document.getElementById("questModal");
  const deleteBtn = document.getElementById("deleteQuestBtn");
  if (id) {
    const quest = quests[category].find((q) => q.id == id);
    document.getElementById("questModalTitle").textContent = "Edit Quest";
    document.getElementById("questId").value = quest.id;
    document.getElementById("questOriginalType").value = category;
    document.getElementById("questType").value = quest.type;
    document.getElementById("questTitle").value = quest.title;
    document.getElementById("questXp").value = quest.xp_reward;
    document.getElementById("questTime").value = quest.due_date || "";
    document.getElementById("questDifficulty").value = quest.difficulty;
    deleteBtn.style.display = "block";
  } else {
    document.getElementById("questModalTitle").textContent = "Add New Quest";
    document.getElementById("questId").value = "";
    document.getElementById("questOriginalType").value = "";
    document.getElementById("questType").value = "daily";
    document.getElementById("questTitle").value = "";
    document.getElementById("questXp").value = 100;
    document.getElementById("questTime").value = "";
    deleteBtn.style.display = "none";
  }
  modal.classList.add("active");
}

function saveQuest() {
  const id = document.getElementById("questId").value;
  const originalType = document.getElementById("questOriginalType").value;
  const newType = document.getElementById("questType").value;
  const title = document.getElementById("questTitle").value;
  const xp_reward = parseInt(document.getElementById("questXp").value);
  const due_date = document.getElementById("questTime").value;
  const difficulty = document.getElementById("questDifficulty").value;
  if (!title) return alert("Title required");

  const questObj = {
    id: id ? parseInt(id) : Date.now(),
    title,
    description: "",
    type: newType,
    xp_reward,
    due_date: due_date || null,
    difficulty,
    status: "active",
  };

  if (id) {
    if (originalType !== newType) {
      quests[originalType] = quests[originalType].filter((q) => q.id != id);
      quests[newType].push(questObj);
    } else {
      const idx = quests[originalType].findIndex((q) => q.id == id);
      quests[originalType][idx] = questObj;
    }
  } else {
    quests[newType].push(questObj);
  }
  refreshAllQuests();
  closeModal("questModal");
}

function deleteQuest() {
  if (confirm("Delete quest?")) {
    const type = document.getElementById("questOriginalType").value;
    quests[type] = quests[type].filter(
      (q) => q.id != document.getElementById("questId").value
    );
    refreshAllQuests();
    closeModal("questModal");
  }
}

// --- XP & UTILS ---
function updateXP() {
  const pct = (userData.xp / userData.xp_to_next) * 100;
  document.getElementById("dashboardXpBar").style.width = `${pct}%`;
  document.getElementById(
    "dashboardXp"
  ).textContent = `${userData.xp.toLocaleString()} / ${userData.xp_to_next.toLocaleString()} XP`;
  if (userData.xp >= userData.xp_to_next) {
    userData.level++;
    userData.xp = 0;
    userData.xp_to_next = Math.floor(userData.xp_to_next * 1.2);
    document.getElementById("levelUpModal").classList.add("active");
  }
}
function closeLevelUp() {
  document.getElementById("levelUpModal").classList.remove("active");
}

// Chat
function sendChatMessage(msg) {
  const chat = document.getElementById("chatMessages");
  chat.innerHTML += `<div class="chat-message" style="background: rgba(59, 130, 246, 0.1); border-left: 3px solid var(--accent-blue);"><strong style="color: var(--accent-blue);">You:</strong> ${msg}</div>`;
  setTimeout(() => {
    chat.innerHTML += `<div class="chat-message" style="background: rgba(168, 85, 247, 0.15); border-left: 3px solid var(--accent-purple);"><strong style="color: var(--accent-purple);">AI Coach:</strong> Good idea! Let's get it done.</div>`;
    chat.scrollTop = chat.scrollHeight;
  }, 800);
}

// Sidebar Collapse/Expand with Drag
let sidebarCollapsed = false;
let isDragging = false;

function toggleSidebar() {
  const sidebar = document.getElementById("sidebar");
  const mainContent = document.getElementById("mainContent");

  sidebarCollapsed = !sidebarCollapsed;

  if (sidebarCollapsed) {
    sidebar.classList.add("collapsed");
    mainContent.classList.remove("with-sidebar");
    mainContent.classList.add("sidebar-collapsed");
  } else {
    sidebar.classList.remove("collapsed");
    mainContent.classList.remove("sidebar-collapsed");
    mainContent.classList.add("with-sidebar");
  }
}

// Events
document.querySelectorAll(".nav-item").forEach((item) => {
  item.addEventListener("click", (e) => {
    if (e.target.dataset.page) navigateTo(e.target.dataset.page);
  });
});

// Init
window.addEventListener("DOMContentLoaded", () => {
  refreshAllQuests();
  renderHabits();
  setTimeout(() => {
    document.getElementById("demoXpBar").style.width = "75%";
  }, 500);

  // Sidebar drag handle functionality
  const dragHandle = document.getElementById("sidebarDragHandle");
  if (dragHandle) {
    dragHandle.addEventListener("click", toggleSidebar);

    dragHandle.addEventListener("mousedown", (e) => {
      isDragging = true;
      e.preventDefault();
    });

    document.addEventListener("mousemove", (e) => {
      if (isDragging) {
        const sidebar = document.getElementById("sidebar");
        const mouseX = e.clientX;

        // Toggle based on drag direction
        if (mouseX < 100 && !sidebarCollapsed) {
          toggleSidebar();
          isDragging = false;
        } else if (mouseX > 150 && sidebarCollapsed) {
          toggleSidebar();
          isDragging = false;
        }
      }
    });

    document.addEventListener("mouseup", () => {
      isDragging = false;
    });
  }
});
