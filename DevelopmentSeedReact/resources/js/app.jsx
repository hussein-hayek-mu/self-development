import React, { useState, useEffect } from 'react';
import './App.css'; // Copy your CSS into this file

const App = () => {
  // --- STATE ---
  const [isLoggedIn, setIsLoggedIn] = useState(false);
  const [currentPage, setCurrentPage] = useState('landing');
  const [authTab, setAuthTab] = useState('login');
  const [userData, setUserData] = useState({ level: 12, xp: 7540, xpToNext: 10000 });
  const [showLevelUp, setShowLevelUp] = useState(false);
  const [showPerfectDay, setShowPerfectDay] = useState(false);

  // Quests State
  const [quests, setQuests] = useState({
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
  });

  // Habits State
  const [habits, setHabits] = useState([
    { id: 1, title: "Morning Exercise", streak: 7, xp: 50, completed: false },
    { id: 2, title: "Gratitude Journal", streak: 12, xp: 30, completed: false },
    { id: 3, title: "No Social Media", streak: 5, xp: 40, completed: false }
  ]);

  // Modals State
  const [habitModal, setHabitModal] = useState({ open: false, data: null });
  const [questModal, setQuestModal] = useState({ open: false, data: null });

  // --- LOGIC ---
  const addXP = (amount) => {
    setUserData(prev => {
      let newXP = prev.xp + amount;
      let newLevel = prev.level;
      if (newXP >= prev.xpToNext) {
        newXP -= prev.xpToNext;
        newLevel++;
        setShowLevelUp(true);
      }
      return { ...prev, xp: newXP, level: newLevel };
    });
  };

  const toggleQuest = (id, category) => {
    const updatedCategory = quests[category].map(q => {
      if (q.id === id) {
        const newState = !q.completed;
        if (newState) addXP(q.xp);
        return { ...q, completed: newState };
      }
      return q;
    });
    setQuests({ ...quests, [category]: updatedCategory });
  };

  const toggleHabit = (id) => {
    const updatedHabits = habits.map(h => {
      if (h.id === id) {
        const newState = !h.completed;
        if (newState) addXP(h.xp);
        return { ...h, completed: newState };
      }
      return h;
    });
    setHabits(updatedHabits);
  };

  // Check for perfect day
  useEffect(() => {
    const allHabitsDone = habits.length > 0 && habits.every(h => h.completed);
    if (allHabitsDone) {
      setShowPerfectDay(true);
      addXP(500);
    } else {
      setShowPerfectDay(false);
    }
  }, [habits]);

  // --- RENDER HELPERS ---
  const renderQuestCard = (quest, category) => (
    <div key={quest.id} className={`quest-card ${quest.completed ? 'completed' : ''}`}>
      <div 
        className={`check-circle ${quest.completed ? 'completed' : ''}`}
        onClick={() => toggleQuest(quest.id, category)}
      >
        {quest.completed ? '✓' : ''}
      </div>
      <div className="card-content">
        <div className="quest-header-row">
          <span className="quest-title">{quest.title}</span>
          <span className="quest-xp-badge">+{quest.xp} XP</span>
        </div>
        <div className="quest-meta-row">
          <span className={`difficulty difficulty-${quest.difficulty}`}>{quest.difficulty.toUpperCase()}</span>
          <span>⏱ {quest.time}</span>
        </div>
      </div>
    </div>
  );

  if (!isLoggedIn) {
    return (
      <div className="auth-screen">
        <div className="auth-card">
          <div className="auth-header">
            <div className="auth-logo">LEVEL UP</div>
            <div className="auth-subtitle">Gamify your life, master your future</div>
          </div>
          <div className="auth-tabs">
            <div className={`auth-tab ${authTab === 'login' ? 'active' : ''}`} onClick={() => setAuthTab('login')}>Login</div>
            <div className={`auth-tab ${authTab === 'register' ? 'active' : ''}`} onClick={() => setAuthTab('register')}>Sign Up</div>
          </div>
          
          <div className={`auth-form ${authTab === 'login' ? 'active' : ''}`}>
            <div className="form-group">
              <label className="form-label">Email Address</label>
              <input type="email" className="form-input" placeholder="hero@levelup.com" />
            </div>
            <div className="form-group">
              <label className="form-label">Password</label>
              <input type="password" className="form-input" placeholder="••••••••" />
            </div>
            <button className="btn btn-primary" onClick={() => { setIsLoggedIn(true); setCurrentPage('dashboard'); }}>Start Game</button>
          </div>

          <div className={`auth-form ${authTab === 'register' ? 'active' : ''}`}>
            <div className="form-group">
              <label className="form-label">Hero Name</label>
              <input type="text" className="form-input" placeholder="e.g. ShadowWalker" />
            </div>
            <div className="form-group">
              <label className="form-label">Email Address</label>
              <input type="email" className="form-input" placeholder="hero@levelup.com" />
            </div>
            <button className="btn btn-primary" onClick={() => { setIsLoggedIn(true); setCurrentPage('dashboard'); }}>Create Account</button>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="app-container visible" style={{ display: 'flex' }}>
      {/* Sidebar */}
      {currentPage !== 'landing' && (
        <nav className="sidebar active">
          <div className="logo">LEVEL UP</div>
          {['landing', 'dashboard', 'habits', 'quests', 'ai', 'analytics', 'community', 'profile'].map(page => (
            <div 
              key={page}
              className={`nav-item ${currentPage === page ? 'active' : ''}`} 
              onClick={() => setCurrentPage(page)}
            >
              {page.charAt(0).toUpperCase() + page.slice(1)}
            </div>
          ))}
          <div className="nav-item" onClick={() => setIsLoggedIn(false)} style={{ marginTop: 'auto', color: '#ef4444' }}>Logout</div>
        </nav>
      )}

      {/* Main Content */}
      <main className={`main-content ${currentPage !== 'landing' ? 'with-sidebar' : ''}`}>
        
        {/* Landing Page */}
        {currentPage === 'landing' && (
          <div className="page active">
            <div className="hero">
              <h1>Your Life Is a Game.<br />Start Leveling Up.</h1>
              <p>Transform your habits into quests, earn XP, and become the hero of your own story.</p>
              <div className="cta-buttons">
                <button className="btn btn-primary" onClick={() => setCurrentPage('dashboard')}>Start Your Journey</button>
              </div>
            </div>
          </div>
        )}

        {/* Dashboard */}
        {currentPage === 'dashboard' && (
          <div className="page active">
            <h1 className="section-header" style={{ marginBottom: '2rem' }}>Dashboard</h1>
            <div className="dashboard-grid">
              <div className="level-card">
                <div className="level-number">{userData.level}</div>
                <div className="level-title">Focused Strategist</div>
              </div>
              <div className="xp-card">
                <h3>XP Progress</h3>
                <div className="xp-text">
                  <span>Current Level</span>
                  <span>{userData.xp.toLocaleString()} / {userData.xpToNext.toLocaleString()} XP</span>
                </div>
                <div className="xp-bar-container">
                  <div className="xp-bar-fill" style={{ width: `${(userData.xp / userData.xpToNext) * 100}%` }}></div>
                </div>
              </div>
            </div>
            <h2 style={{ margin: '3rem 0 1.5rem', fontSize: '1.5rem' }}>Today's Quests</h2>
            <div className="quests-list">
              {quests.daily.map(q => renderQuestCard(q, 'daily'))}
            </div>
          </div>
        )}

        {/* Habits Page */}
        {currentPage === 'habits' && (
          <div className="page active">
            <div className="page-header-actions">
              <h1 className="section-header">Habits</h1>
              <button className="btn btn-primary btn-small">+ Add Habit</button>
            </div>
            {habits.map(habit => (
              <div key={habit.id} className={`habit-card ${habit.completed ? 'completed' : ''}`}>
                <div 
                  className={`habit-toggle ${habit.completed ? 'completed' : ''}`}
                  onClick={() => toggleHabit(habit.id)}
                />
                <div className="card-content">
                   <div className="quest-header-row">
                      <span className="quest-title">{habit.title}</span>
                      <span className="quest-xp-badge">+{habit.xp} XP</span>
                   </div>
                   <div className="quest-meta-row">
                      <span>🔥 {habit.streak} Day Streak</span>
                   </div>
                </div>
              </div>
            ))}
            {showPerfectDay && (
              <div id="perfectDayBonus">🎉 PERFECT DAY! +500 BONUS XP!</div>
            )}
          </div>
        )}

        {/* Quests Page */}
        {currentPage === 'quests' && (
          <div className="page active">
            <div className="page-header-actions">
              <h1 className="section-header">Quests</h1>
              <button className="btn btn-primary btn-small">+ Add Quest</button>
            </div>
            <h2 style={{ margin: '2rem 0 1rem', fontSize: '1.25rem' }}>Daily Quests</h2>
            {quests.daily.map(q => renderQuestCard(q, 'daily'))}
            <h2 style={{ margin: '2rem 0 1rem', fontSize: '1.25rem' }}>Weekly Quests</h2>
            {quests.weekly.map(q => renderQuestCard(q, 'weekly'))}
            <h2 style={{ margin: '2rem 0 1rem', fontSize: '1.25rem' }}>Boss Quests</h2>
            {quests.boss.map(q => renderQuestCard(q, 'boss'))}
          </div>
        )}

        {/* AI Coach */}
        {currentPage === 'ai' && (
          <div className="page active">
             <h1 className="section-header" style={{ marginBottom: '2rem' }}>AI Coach</h1>
             <div className="chat-window">
                <div className="chat-messages">
                   <div className="chat-message">
                      <strong>AI Coach:</strong> Welcome back, warrior! Ready to level up today?
                   </div>
                </div>
                <div className="chat-input-area">
                   <div className="chat-suggestions">
                      <button className="btn btn-secondary btn-small" style={{width: 'auto', marginRight: '10px'}}>🎯 Focus Task</button>
                      <button className="btn btn-secondary btn-small" style={{width: 'auto'}}>💪 Motivation</button>
                   </div>
                </div>
             </div>
          </div>
        )}
      </main>

      {/* Level Up Modal */}
      {showLevelUp && (
        <div className="level-up-modal active">
          <div className="level-up-content">
            <h2>LEVEL UP!</h2>
            <p style={{ fontSize: '1.5rem' }}>You've reached Level {userData.level}!</p>
            <button className="btn btn-primary" onClick={() => setShowLevelUp(false)} style={{ marginTop: '2rem' }}>Continue</button>
          </div>
        </div>
      )}
    </div>
  );
};

export default App;