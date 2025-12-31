import { classNames } from './classNames';

export function Analytics({ activePage }) {
    return (
        <div
            className={classNames(
                'page',
                activePage === 'analytics' && 'active',
            )}
            id="page-analytics"
        >
            <h1 className="section-header" style={{ marginBottom: '2rem' }}>
                Analytics
            </h1>
            <div className="stats-grid">
                <div className="stat-card">
                    <div className="stat-value">24</div>
                    <div className="stat-label">Quests This Week</div>
                </div>
                <div className="stat-card">
                    <div className="stat-value">89%</div>
                    <div className="stat-label">Habit Success Rate</div>
                </div>
            </div>
        </div>
    );
}
