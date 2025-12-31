import { classNames } from './classNames';

export function Profile({ activePage, userData }) {
    return (
        <div
            className={classNames('page', activePage === 'profile' && 'active')}
            id="page-profile"
        >
            <div className="profile-header">
                <div className="avatar"></div>
                <h1>Focused Strategist</h1>
                <p>
                    Level {userData.level} • {userData.xp.toLocaleString()} XP
                </p>
            </div>
        </div>
    );
}
