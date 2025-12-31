import { classNames } from './classNames';

export function Dashboard({
    activePage,
    userData,
    quests,
    onToggleQuest,
    onEditQuest,
}) {
    return (
        <div
            className={classNames(
                'page',
                activePage === 'dashboard' && 'active',
            )}
            id="page-dashboard"
        >
            <h1 className="section-header" style={{ marginBottom: '2rem' }}>
                Dashboard
            </h1>
            <div className="dashboard-grid">
                <div className="level-card">
                    <div className="level-number">{userData.level}</div>
                    <div className="level-title">Focused Strategist</div>
                </div>
                <div className="xp-card">
                    <h3>XP Progress</h3>
                    <div className="xp-text">
                        <span>Current Level</span>
                        <span>{`${userData.xp.toLocaleString()} / ${userData.xpToNext.toLocaleString()} XP`}</span>
                    </div>
                    <div className="xp-bar-container">
                        <div
                            className="xp-bar-fill"
                            style={{
                                width: `${Math.min(100, (userData.xp / userData.xpToNext) * 100)}%`,
                            }}
                        ></div>
                    </div>
                </div>
            </div>

            <h2
                style={{
                    margin: '3rem 0 1.5rem',
                    fontSize: '1.5rem',
                    textAlign: 'left',
                }}
            >
                Today&apos;s Quests
            </h2>
            <div id="dashboardQuests">
                {quests.daily.map((quest) => (
                    <div
                        key={quest.id}
                        className={classNames(
                            'quest-card',
                            quest.completed && 'completed',
                        )}
                    >
                        <div
                            className={classNames(
                                'check-circle',
                                quest.completed && 'completed',
                            )}
                            onClick={() => onToggleQuest(quest.id, 'daily')}
                        >
                            {quest.completed ? '✓' : ''}
                        </div>
                        <div className="card-content">
                            <div className="quest-header-row">
                                <div className="quest-title">{quest.title}</div>
                                <div className="quest-xp-badge">
                                    +{quest.xp} XP
                                </div>
                            </div>
                            <div className="quest-meta-row">
                                <span
                                    className={classNames(
                                        'difficulty',
                                        `difficulty-${quest.difficulty}`,
                                    )}
                                >
                                    {quest.difficulty.toUpperCase()}
                                </span>
                                <span>⏱️ {quest.time}</span>
                                <div className="card-actions">
                                    <span
                                        className="action-icon"
                                        onClick={() =>
                                            onEditQuest(quest.id, 'daily')
                                        }
                                    >
                                        ✏️
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
}
