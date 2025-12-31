import { classNames } from './classNames';

const pages = [
    { key: 'landing', label: 'Home' },
    { key: 'dashboard', label: 'Dashboard' },
    { key: 'habits', label: 'Habits' },
    { key: 'quests', label: 'Quests' },
    { key: 'ai', label: 'AI Coach' },
    { key: 'analytics', label: 'Analytics' },
    { key: 'community', label: 'Community' },
    { key: 'profile', label: 'Profile' },
];

export function Sidebar({ activePage, onNavigate, onLogout }) {
    return (
        <nav
            className={classNames(
                'sidebar',
                activePage !== 'landing' && 'active',
            )}
        >
            <div className="logo">LEVEL UP</div>
            {pages.map((page) => (
                <div
                    key={page.key}
                    className={classNames(
                        'nav-item',
                        activePage === page.key && 'active',
                    )}
                    onClick={() => onNavigate(page.key)}
                >
                    {page.label}
                </div>
            ))}
            <div
                className="nav-item"
                onClick={onLogout}
                style={{
                    marginTop: 'auto',
                    color: '#ef4444',
                    borderLeftColor: 'transparent',
                }}
            >
                Logout
            </div>
        </nav>
    );
}
