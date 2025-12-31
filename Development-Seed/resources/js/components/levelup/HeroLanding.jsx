import { classNames } from './classNames';

export function HeroLanding({ activePage, onStart }) {
    return (
        <div
            className={classNames('page', activePage === 'landing' && 'active')}
            id="page-landing"
        >
            <div className="hero">
                <h1>
                    Your Life Is a Game.
                    <br />
                    Start Leveling Up.
                </h1>
                <p>
                    Transform your habits into quests, earn XP, and become the
                    hero of your own story.
                </p>
                <div className="cta-buttons">
                    <button className="btn btn-primary" onClick={onStart}>
                        Start Your Journey
                    </button>
                </div>
            </div>
        </div>
    );
}
