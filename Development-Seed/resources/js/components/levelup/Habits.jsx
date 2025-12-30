import { classNames } from './classNames';

export function Habits({
    activePage,
    habits,
    perfectDay,
    onToggleHabit,
    onOpenHabitModal,
}) {
    return (
        <div
            className={classNames('page', activePage === 'habits' && 'active')}
            id="page-habits"
        >
            <div className="page-header-actions">
                <h1 className="section-header">Habits</h1>
                <button
                    className="btn btn-primary btn-small"
                    onClick={() => onOpenHabitModal()}
                >
                    + Add Habit
                </button>
            </div>
            <div id="habitsList">
                {habits.map((habit) => (
                    <div
                        key={habit.id}
                        className={classNames(
                            'habit-card',
                            habit.completed && 'completed',
                        )}
                    >
                        <div
                            className={classNames(
                                'habit-toggle',
                                habit.completed && 'completed',
                            )}
                            onClick={() => onToggleHabit(habit.id)}
                        ></div>
                        <div className="card-content">
                            <div className="quest-title">{habit.title}</div>
                            <div
                                className="quest-meta-row"
                                style={{ marginTop: 5 }}
                            >
                                <span
                                    style={{
                                        color: 'var(--accent-gold)',
                                        fontWeight: 600,
                                    }}
                                >
                                    🔥 {habit.streak} day streak
                                </span>
                                <span>+{habit.xp} XP</span>
                                <div className="card-actions">
                                    <span
                                        className="action-icon"
                                        onClick={() =>
                                            onOpenHabitModal(habit.id)
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
            {perfectDay && (
                <div
                    id="perfectDayBonus"
                    style={{
                        marginTop: '2rem',
                        padding: '2rem',
                        background:
                            'linear-gradient(135deg, var(--accent-gold), #f59e0b)',
                        borderRadius: '12px',
                        textAlign: 'center',
                        fontSize: '1.5rem',
                        fontWeight: 700,
                        animation: 'fadeIn 0.5s',
                    }}
                >
                    🎉 PERFECT DAY! +500 BONUS XP!
                </div>
            )}
        </div>
    );
}
