import { classNames } from './classNames';

export function LevelUpModal({ show, level, onClose }) {
    return (
        <div
            className={classNames('level-up-modal', show && 'active')}
            id="levelUpModal"
        >
            <div className="level-up-content">
                <h2>LEVEL UP!</h2>
                <p style={{ fontSize: '1.5rem' }}>
                    You&apos;ve reached Level {level}!
                </p>
                <button
                    className="btn btn-primary"
                    onClick={onClose}
                    style={{ marginTop: '2rem' }}
                >
                    Continue
                </button>
            </div>
        </div>
    );
}
