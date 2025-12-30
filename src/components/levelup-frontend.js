    // --- DATA & LOGIC ---
        const userData = { level: 12, xp: 7540, xpToNext: 10000 };

        let quests = {
            daily: [
                { id: 1, title: "Morning Meditation", difficulty: "easy", xp: 50, time: "15 min", completed: false },
                { id: 2, title: "Read 30 Pages", difficulty: "easy", xp: 100, time: "30 min", completed: false },
                { id: 3, title: "Workout Session", difficulty: "medium", xp: 150, time: "45 min", completed: false }
            ],
            weekly: [
                { id: 4, title: "Complete Side Project Milestone", difficulty: "medium", xp: 500, time: "5 days left", completed: false }
            ],
            boss: [
                { id: 6, title: "Launch Your Product", difficulty: "hard", xp: 2000, time: "2 weeks left", completed: false }
            ]
        };

        let habits = [
            { id: 1, title: "Morning Exercise", streak: 7, xp: 50, completed: false },
            { id: 2, title: "Gratitude Journal", streak: 12, xp: 30, completed: false },
            { id: 3, title: "No Social Media", streak: 5, xp: 40, completed: false }
        ];

        // --- AUTH ---
        function switchAuthTab(tab) {
            document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.auth-form').forEach(f => f.classList.remove('active'));
            if(tab === 'login') {
                document.querySelector('.auth-tab:first-child').classList.add('active');
                document.getElementById('loginForm').classList.add('active');
            } else {
                document.querySelector('.auth-tab:last-child').classList.add('active');
                document.getElementById('registerForm').classList.add('active');
            }
        }

        function simulateLogin() {
            document.getElementById('authScreen').classList.add('hidden');
            document.getElementById('appContainer').style.display = 'flex';
            setTimeout(() => {
                document.getElementById('appContainer').classList.add('visible');
                startJourney();
            }, 100);
        }

        function logout() {
            document.getElementById('appContainer').classList.remove('visible');
            setTimeout(() => {
                document.getElementById('appContainer').style.display = 'none';
                document.getElementById('authScreen').classList.remove('hidden');
            }, 500);
        }

        // --- NAVIGATION ---
        function navigateTo(pageName) {
            document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
            document.getElementById(`page-${pageName}`).classList.add('active');
            const nav = document.querySelector(`[data-page="${pageName}"]`);
            if(nav) nav.classList.add('active');
            
            const sb = document.getElementById('sidebar');
            const mc = document.getElementById('mainContent');
            if(pageName !== 'landing') {
                sb.classList.add('active'); mc.classList.add('with-sidebar');
            } else {
                sb.classList.remove('active'); mc.classList.remove('with-sidebar');
            }
        }

        function startJourney() {
            navigateTo('dashboard');
            setTimeout(() => { document.getElementById('dashboardXpBar').style.width = '75%'; }, 100);
        }

        // --- RENDERING ---
        function renderQuests(questArray, containerId, category) {
            const container = document.getElementById(containerId);
            container.innerHTML = questArray.map(quest => `
                <div class="quest-card ${quest.completed ? 'completed' : ''}">
                    <!-- Check Circle Toggle -->
                    <div class="check-circle ${quest.completed ? 'completed' : ''}" 
                         onclick="toggleQuest(${quest.id}, '${category}')">
                         ${quest.completed ? '✓' : ''}
                    </div>

                    <div class="card-content">
                        <div class="quest-header-row">
                            <div class="quest-title">${quest.title}</div>
                            <div class="quest-xp-badge">+${quest.xp} XP</div>
                        </div>
                        <div class="quest-meta-row">
                            <span class="difficulty difficulty-${quest.difficulty}">${quest.difficulty.toUpperCase()}</span>
                            <span>⏱️ ${quest.time}</span>
                            <div class="card-actions">
                                <span class="action-icon" onclick="openQuestModal(${quest.id}, '${category}')">✏️</span>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function refreshAllQuests() {
            renderQuests(quests.daily, 'dashboardQuests', 'daily');
            renderQuests(quests.daily, 'dailyQuests', 'daily');
            renderQuests(quests.weekly, 'weeklyQuests', 'weekly');
            renderQuests(quests.boss, 'bossQuests', 'boss');
        }

        function renderHabits() {
            const container = document.getElementById('habitsList');
            container.innerHTML = habits.map(habit => `
                <div class="habit-card ${habit.completed ? 'completed' : ''}">
                    <div class="habit-toggle ${habit.completed ? 'completed' : ''}" onclick="toggleHabit(${habit.id})"></div>
                    <div class="card-content">
                        <div class="quest-title">${habit.title}</div>
                        <div class="quest-meta-row" style="margin-top: 5px;">
                            <span style="color: var(--accent-gold); font-weight:600;">🔥 ${habit.streak} day streak</span>
                            <span>+${habit.xp} XP</span>
                            <div class="card-actions">
                                <span class="action-icon" onclick="openHabitModal(${habit.id})">✏️</span>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        // --- ACTIONS ---
        function toggleQuest(id, category) {
            const quest = quests[category].find(q => q.id === id);
            quest.completed = !quest.completed;
            
            if (quest.completed) {
                userData.xp += quest.xp;
                updateXP();
            } else {
                userData.xp -= quest.xp; // Optional: Remove XP if unchecked
                updateXP();
            }
            refreshAllQuests();
        }

        function toggleHabit(id) {
            const habit = habits.find(h => h.id === id);
            habit.completed = !habit.completed;
            renderHabits();
            
            const allCompleted = habits.every(h => h.completed);
            const bonusDiv = document.getElementById('perfectDayBonus');
            bonusDiv.style.display = allCompleted ? 'block' : 'none';
            
            if (habit.completed) {
                userData.xp += habit.xp;
            } else {
                userData.xp -= habit.xp;
            }
            updateXP();
        }

        // --- MODALS (CRUD) ---
        function closeModal(modalId) { document.getElementById(modalId).classList.remove('active'); }

        // Habit CRUD
        function openHabitModal(id = null) {
            const modal = document.getElementById('habitModal');
            const deleteBtn = document.getElementById('deleteHabitBtn');
            if (id) {
                const habit = habits.find(h => h.id === id);
                document.getElementById('habitModalTitle').textContent = "Edit Habit";
                document.getElementById('habitId').value = habit.id;
                document.getElementById('habitTitle').value = habit.title;
                document.getElementById('habitXp').value = habit.xp;
                deleteBtn.style.display = 'block';
            } else {
                document.getElementById('habitModalTitle').textContent = "Add New Habit";
                document.getElementById('habitId').value = '';
                document.getElementById('habitTitle').value = '';
                document.getElementById('habitXp').value = 50;
                deleteBtn.style.display = 'none';
            }
            modal.classList.add('active');
        }

        function saveHabit() {
            const id = document.getElementById('habitId').value;
            const title = document.getElementById('habitTitle').value;
            const xp = parseInt(document.getElementById('habitXp').value);
            if (!title) return alert("Title required");

            if (id) {
                const habit = habits.find(h => h.id == id);
                habit.title = title; habit.xp = xp;
            } else {
                habits.push({ id: Date.now(), title, streak: 0, xp, completed: false });
            }
            renderHabits(); closeModal('habitModal');
        }

        function deleteHabit() {
            if(confirm("Delete habit?")) {
                habits = habits.filter(h => h.id != document.getElementById('habitId').value);
                renderHabits(); closeModal('habitModal');
            }
        }

        // Quest CRUD
        function openQuestModal(id = null, category = 'daily') {
            const modal = document.getElementById('questModal');
            const deleteBtn = document.getElementById('deleteQuestBtn');
            if (id) {
                const quest = quests[category].find(q => q.id == id);
                document.getElementById('questModalTitle').textContent = "Edit Quest";
                document.getElementById('questId').value = quest.id;
                document.getElementById('questOriginalType').value = category;
                document.getElementById('questType').value = category;
                document.getElementById('questTitle').value = quest.title;
                document.getElementById('questXp').value = quest.xp;
                document.getElementById('questTime').value = quest.time;
                document.getElementById('questDifficulty').value = quest.difficulty;
                deleteBtn.style.display = 'block';
            } else {
                document.getElementById('questModalTitle').textContent = "Add New Quest";
                document.getElementById('questId').value = '';
                document.getElementById('questOriginalType').value = '';
                document.getElementById('questType').value = 'daily';
                document.getElementById('questTitle').value = '';
                document.getElementById('questXp').value = 100;
                document.getElementById('questTime').value = '';
                deleteBtn.style.display = 'none';
            }
            modal.classList.add('active');
        }

        function saveQuest() {
            const id = document.getElementById('questId').value;
            const originalType = document.getElementById('questOriginalType').value;
            const newType = document.getElementById('questType').value;
            const title = document.getElementById('questTitle').value;
            const xp = parseInt(document.getElementById('questXp').value);
            const time = document.getElementById('questTime').value;
            const difficulty = document.getElementById('questDifficulty').value;
            if (!title) return alert("Title required");

            const questObj = { id: id ? parseInt(id) : Date.now(), title, xp, time, difficulty, completed: false };

            if (id) {
                if (originalType !== newType) {
                    quests[originalType] = quests[originalType].filter(q => q.id != id);
                    quests[newType].push(questObj);
                } else {
                    const idx = quests[originalType].findIndex(q => q.id == id);
                    quests[originalType][idx] = questObj;
                }
            } else {
                quests[newType].push(questObj);
            }
            refreshAllQuests(); closeModal('questModal');
        }

        function deleteQuest() {
            if(confirm("Delete quest?")) {
                const type = document.getElementById('questOriginalType').value;
                quests[type] = quests[type].filter(q => q.id != document.getElementById('questId').value);
                refreshAllQuests(); closeModal('questModal');
            }
        }

        // --- XP & UTILS ---
        function updateXP() {
            const pct = (userData.xp / userData.xpToNext) * 100;
            document.getElementById('dashboardXpBar').style.width = `${pct}%`;
            document.getElementById('dashboardXp').textContent = `${userData.xp.toLocaleString()} / ${userData.xpToNext.toLocaleString()} XP`;
            if (userData.xp >= userData.xpToNext) {
                userData.level++; userData.xp = 0; userData.xpToNext = Math.floor(userData.xpToNext * 1.2);
                document.getElementById('levelUpModal').classList.add('active');
            }
        }
        function closeLevelUp() { document.getElementById('levelUpModal').classList.remove('active'); }

        // Chat
        function sendChatMessage(msg) {
            const chat = document.getElementById('chatMessages');
            chat.innerHTML += `<div class="chat-message"><strong>You:</strong> ${msg}</div>`;
            setTimeout(() => {
                chat.innerHTML += `<div class="chat-message"><strong>AI Coach:</strong> Good idea! Let's get it done.</div>`;
                chat.scrollTop = chat.scrollHeight;
            }, 800);
        }

        // Events
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', (e) => {
                if(e.target.dataset.page) navigateTo(e.target.dataset.page);
            });
        });

        // Init
        window.addEventListener('DOMContentLoaded', () => {
            refreshAllQuests(); renderHabits();
            setTimeout(() => { document.getElementById('demoXpBar').style.width = '75%'; }, 500);
        });