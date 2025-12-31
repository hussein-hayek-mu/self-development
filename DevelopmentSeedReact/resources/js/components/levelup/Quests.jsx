import { classNames } from './classNames';

const sections = [
    { key: 'daily', label: 'Daily Quests' },
    { key: 'weekly', label: 'Weekly Quests' },
    { key: 'boss', label: 'Boss Quests' },
];

export function Quests({
    activePage,
    quests,
    onToggleQuest,
    onOpenQuestModal,
}) {
    const renderQuests = (key, items) => (
        <div key={key}>
            <h2
                style={{
                    margin: '2rem 0 1rem',
                    fontSize: '1.25rem',
                    textAlign: 'left',
                }}
            >
                {sections.find((s) => s.key === key)?.label}
            </h2>
            <div id={`${key}Quests`}>
                {items.map((quest) => (
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
                            onClick={() => onToggleQuest(quest.id, key)}
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
                                            onOpenQuestModal(quest.id, key)
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

    return (
        <div
            className={classNames('page', activePage === 'quests' && 'active')}
            id="page-quests"
        >
            <div className="page-header-actions">
                <h1 className="section-header">Quests</h1>
                <button
                    className="btn btn-primary btn-small"
                    onClick={() => onOpenQuestModal()}
                >
                    + Add Quest
                </button>
            </div>
            {sections.map((section) =>
                renderQuests(section.key, quests[section.key]),
            )}
        </div>
    );
}
