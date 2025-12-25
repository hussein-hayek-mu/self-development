import { useState } from 'react';
import { LandingPage } from './components/LandingPage';
import { LoginPage } from './components/LoginPage';
import { Sidebar } from './components/Sidebar';
import { Dashboard } from './components/Dashboard';
import { HabitsPage } from './components/HabitsPage';
import { QuestsPage } from './components/QuestsPage';
import { AICoachPage } from './components/AICoachPage';
import { ProgressPage } from './components/ProgressPage';
import { CommunityPage } from './components/CommunityPage';
import { ProfilePage } from './components/ProfilePage';

export default function App() {
  const [currentPage, setCurrentPage] = useState('landing');

  const navigate = (page) => {
    setCurrentPage(page);
  };

  // Landing and Login pages (full screen, no sidebar)
  if (currentPage === 'landing') {
    return <LandingPage onNavigate={navigate} />;
  }

  if (currentPage === 'login') {
    return <LoginPage onNavigate={navigate} />;
  }

  // Main app pages (with sidebar)
  return (
    <div className="min-h-screen bg-black">
      <Sidebar currentPage={currentPage} onNavigate={navigate} />
      <main className="ml-60 p-8">
        <div className="max-w-7xl mx-auto">
          {currentPage === 'dashboard' && <Dashboard />}
          {currentPage === 'habits' && <HabitsPage />}
          {currentPage === 'quests' && <QuestsPage />}
          {currentPage === 'ai-coach' && <AICoachPage />}
          {currentPage === 'progress' && <ProgressPage />}
          {currentPage === 'community' && <CommunityPage />}
          {currentPage === 'profile' && <ProfilePage />}
        </div>
      </main>
    </div>
  );
}