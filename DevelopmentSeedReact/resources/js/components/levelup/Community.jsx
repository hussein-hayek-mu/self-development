import { classNames } from './classNames';

export function Community({ activePage }) {
    return (
        <div
            className={classNames(
                'page',
                activePage === 'community' && 'active',
            )}
            id="page-community"
        >
            <h1 className="section-header" style={{ marginBottom: '2rem' }}>
                Community
            </h1>
            <div className="guild-card">
                <div className="quest-header-row">
                    <h3>⚔️ Morning Warriors</h3>
                </div>
                <p>Conquer your morning routine.</p>
            </div>
        </div>
    );
}
