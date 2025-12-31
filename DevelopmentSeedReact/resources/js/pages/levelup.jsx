import { Head } from '@inertiajs/react';
import { useEffect, useMemo, useState } from 'react';
import { AiCoach } from '../components/levelup/AiCoach';
import { Analytics } from '../components/levelup/Analytics';
import { AuthScreen } from '../components/levelup/AuthScreen';
import { Community } from '../components/levelup/Community';
import { Dashboard } from '../components/levelup/Dashboard';
import { HabitModal } from '../components/levelup/HabitModal';
import { Habits } from '../components/levelup/Habits';
import { HeroLanding } from '../components/levelup/HeroLanding';
import { LevelUpModal } from '../components/levelup/LevelUpModal';
import { Profile } from '../components/levelup/Profile';
import { QuestModal } from '../components/levelup/QuestModal';
import { Quests } from '../components/levelup/Quests';
import { Sidebar } from '../components/levelup/Sidebar';
import { StyleTag } from '../components/levelup/StyleTag';
import { classNames } from '../components/levelup/classNames';

export default function LevelUpPage() {
    const [authTab, setAuthTab] = useState('login');
    const [isAuthed, setIsAuthed] = useState(false);
    const [activePage, setActivePage] = useState('landing');
    const [userData, setUserData] = useState({
        level: 12,
        xp: 7540,
        xpToNext: 10000,
    });
    const [quests, setQuests] = useState({
        daily: [
            {
                id: 1,
                title: 'Morning Meditation',
                difficulty: 'easy',
                xp: 50,
                time: '15 min',
                completed: false,
            },
            {
                id: 2,
                title: 'Read 30 Pages',
                difficulty: 'easy',
                xp: 100,
                time: '30 min',
                completed: false,
            },
            {
                id: 3,
                title: 'Workout Session',
                difficulty: 'medium',
                xp: 150,
                time: '45 min',
                completed: false,
            },
        ],
        weekly: [
            {
                id: 4,
                title: 'Complete Side Project Milestone',
                difficulty: 'medium',
                xp: 500,
                time: '5 days left',
                completed: false,
            },
        ],
        boss: [
            {
                id: 6,
                title: 'Launch Your Product',
                difficulty: 'hard',
                xp: 2000,
                time: '2 weeks left',
                completed: false,
            },
        ],
    });
    const [habits, setHabits] = useState([
        {
            id: 1,
            title: 'Morning Exercise',
            streak: 7,
            xp: 50,
            completed: false,
        },
        {
            id: 2,
            title: 'Gratitude Journal',
            streak: 12,
            xp: 30,
            completed: false,
        },
        {
            id: 3,
            title: 'No Social Media',
            streak: 5,
            xp: 40,
            completed: false,
        },
    ]);
    const [showLevelUp, setShowLevelUp] = useState(false);
    const [habitForm, setHabitForm] = useState({ id: null, title: '', xp: 50 });
    const [questForm, setQuestForm] = useState({
        id: null,
        originalType: '',
        type: 'daily',
        title: '',
        xp: 100,
        time: '',
        difficulty: 'easy',
    });
    const [showHabitModal, setShowHabitModal] = useState(false);
    const [showQuestModal, setShowQuestModal] = useState(false);
    const [chatMessages, setChatMessages] = useState([
        { from: 'AI', text: 'Welcome back, warrior! Ready to level up today?' },
    ]);

    const perfectDay = useMemo(
        () => habits.every((h) => h.completed),
        [habits],
    );

    const adjustXp = (delta) => {
        setUserData((prev) => {
            let xp = prev.xp + delta;
            let level = prev.level;
            let xpToNext = prev.xpToNext;
            let leveled = false;
            while (xp >= xpToNext) {
                xp -= xpToNext;
                level += 1;
                xpToNext = Math.floor(xpToNext * 1.2);
                leveled = true;
            }
            setShowLevelUp(leveled);
            return { level, xp, xpToNext };
        });
    };

    const toggleQuest = (id, category) => {
        setQuests((prev) => {
            const updated = { ...prev };
            updated[category] = prev[category].map((q) =>
                q.id === id ? { ...q, completed: !q.completed } : q,
            );
            const quest = prev[category].find((q) => q.id === id);
            if (quest) {
                adjustXp(quest.completed ? -quest.xp : quest.xp);
            }
            return updated;
        });
    };

    const toggleHabit = (id) => {
        setHabits((prev) => {
            const updated = prev.map((h) =>
                h.id === id ? { ...h, completed: !h.completed } : h,
            );
            const habit = prev.find((h) => h.id === id);
            if (habit) adjustXp(habit.completed ? -habit.xp : habit.xp);
            return updated;
        });
    };

    const openHabitModal = (id = null) => {
        if (id !== null) {
            const habit = habits.find((h) => h.id === id);
            if (!habit) return;
            setHabitForm({ id: habit.id, title: habit.title, xp: habit.xp });
        } else {
            setHabitForm({ id: null, title: '', xp: 50 });
        }
        setShowHabitModal(true);
    };

    const saveHabit = () => {
        if (!habitForm.title.trim()) return alert('Title required');
        setHabits((prev) => {
            if (habitForm.id) {
                return prev.map((h) =>
                    h.id === habitForm.id
                        ? { ...h, title: habitForm.title, xp: habitForm.xp }
                        : h,
                );
            }
            return [
                ...prev,
                {
                    id: Date.now(),
                    title: habitForm.title,
                    xp: habitForm.xp,
                    streak: 0,
                    completed: false,
                },
            ];
        });
        setShowHabitModal(false);
    };

    const deleteHabit = () => {
        if (!habitForm.id) return;
        if (!window.confirm('Delete habit?')) return;
        setHabits((prev) => prev.filter((h) => h.id !== habitForm.id));
        setShowHabitModal(false);
    };

    const openQuestModal = (id = null, category = 'daily') => {
        if (id !== null) {
            const quest = quests[category].find((q) => q.id === id);
            if (!quest) return;
            setQuestForm({
                id: quest.id,
                originalType: category,
                type: category,
                title: quest.title,
                xp: quest.xp,
                time: quest.time,
                difficulty: quest.difficulty,
            });
        } else {
            setQuestForm({
                id: null,
                originalType: '',
                type: 'daily',
                title: '',
                xp: 100,
                time: '',
                difficulty: 'easy',
            });
        }
        setShowQuestModal(true);
    };

    const saveQuest = () => {
        if (!questForm.title.trim()) return alert('Title required');
        const questObj = {
            id: questForm.id ?? Date.now(),
            title: questForm.title,
            xp: questForm.xp,
            time: questForm.time,
            difficulty: questForm.difficulty,
            completed: false,
        };
        setQuests((prev) => {
            const next = {
                daily: [...prev.daily],
                weekly: [...prev.weekly],
                boss: [...prev.boss],
            };
            if (questForm.id && questForm.originalType) {
                next[questForm.originalType] = next[
                    questForm.originalType
                ].filter((q) => q.id !== questForm.id);
            }
            next[questForm.type] =
                questForm.id && questForm.originalType === questForm.type
                    ? next[questForm.type].map((q) =>
                          q.id === questForm.id ? questObj : q,
                      )
                    : [...next[questForm.type], questObj];
            return next;
        });
        setShowQuestModal(false);
    };

    const deleteQuest = () => {
        if (!questForm.id || !questForm.originalType) return;
        if (!window.confirm('Delete quest?')) return;
        setQuests((prev) => {
            const next = { ...prev };
            next[questForm.originalType] = prev[questForm.originalType].filter(
                (q) => q.id !== questForm.id,
            );
            return next;
        });
        setShowQuestModal(false);
    };

    const navigateTo = (page) => {
        setActivePage(page);
    };

    const startJourney = () => {
        navigateTo('dashboard');
    };

    const simulateLogin = () => {
        setIsAuthed(true);
        setActivePage('dashboard');
    };

    const logout = () => {
        setIsAuthed(false);
        setActivePage('landing');
    };

    const sendChatMessage = (msg) => {
        setChatMessages((prev) => [...prev, { from: 'You', text: msg }]);
        setTimeout(() => {
            setChatMessages((prev) => [
                ...prev,
                { from: 'AI', text: "Good idea! Let's get it done." },
            ]);
        }, 800);
    };

    useEffect(() => {
        startJourney();
    }, []);

    return (
        <div>
            <Head title="Level Up" />
            <StyleTag />

            <AuthScreen
                authTab={authTab}
                onTabChange={setAuthTab}
                onLogin={simulateLogin}
                isAuthed={isAuthed}
            />

            <div className={classNames('app-container', isAuthed && 'visible')}>
                <Sidebar
                    activePage={activePage}
                    onNavigate={navigateTo}
                    onLogout={logout}
                />

                <main
                    className={classNames(
                        'main-content',
                        activePage !== 'landing' && 'with-sidebar',
                    )}
                >
                    <HeroLanding
                        activePage={activePage}
                        onStart={startJourney}
                    />
                    <Dashboard
                        activePage={activePage}
                        userData={userData}
                        quests={quests}
                        onToggleQuest={toggleQuest}
                        onEditQuest={openQuestModal}
                    />
                    <Habits
                        activePage={activePage}
                        habits={habits}
                        perfectDay={perfectDay}
                        onToggleHabit={toggleHabit}
                        onOpenHabitModal={openHabitModal}
                    />
                    <Quests
                        activePage={activePage}
                        quests={quests}
                        onToggleQuest={toggleQuest}
                        onOpenQuestModal={openQuestModal}
                    />
                    <AiCoach
                        activePage={activePage}
                        chatMessages={chatMessages}
                        onSendChatMessage={sendChatMessage}
                    />
                    <Analytics activePage={activePage} />
                    <Community activePage={activePage} />
                    <Profile activePage={activePage} userData={userData} />
                </main>
            </div>

            <LevelUpModal
                show={showLevelUp}
                level={userData.level}
                onClose={() => setShowLevelUp(false)}
            />

            <HabitModal
                show={showHabitModal}
                form={habitForm}
                onChange={setHabitForm}
                onSave={saveHabit}
                onDelete={deleteHabit}
                onClose={() => setShowHabitModal(false)}
            />

            <QuestModal
                show={showQuestModal}
                form={questForm}
                onChange={setQuestForm}
                onSave={saveQuest}
                onDelete={deleteQuest}
                onClose={() => setShowQuestModal(false)}
            />
        </div>
    );
}
