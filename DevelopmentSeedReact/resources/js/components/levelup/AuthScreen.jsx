import { classNames } from './classNames';

export function AuthScreen({ authTab, onTabChange, onLogin, isAuthed }) {
    return (
        <div className={classNames('auth-screen', isAuthed && 'hidden')}>
            <div className="auth-card">
                <div className="auth-header">
                    <div className="auth-logo">LEVEL UP</div>
                    <div className="auth-subtitle">
                        Gamify your life, master your future
                    </div>
                </div>
                <div className="auth-tabs">
                    <div
                        className={classNames(
                            'auth-tab',
                            authTab === 'login' && 'active',
                        )}
                        onClick={() => onTabChange('login')}
                    >
                        Login
                    </div>
                    <div
                        className={classNames(
                            'auth-tab',
                            authTab === 'register' && 'active',
                        )}
                        onClick={() => onTabChange('register')}
                    >
                        Sign Up
                    </div>
                </div>
                <div
                    className={classNames(
                        'auth-form',
                        authTab === 'login' && 'active',
                    )}
                >
                    <div className="form-group">
                        <label className="form-label">Email Address</label>
                        <input
                            type="email"
                            className="form-input"
                            placeholder="hero@levelup.com"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label">Password</label>
                        <input
                            type="password"
                            className="form-input"
                            placeholder="••••••••"
                        />
                    </div>
                    <button className="btn btn-primary" onClick={onLogin}>
                        Start Game
                    </button>
                </div>
                <div
                    className={classNames(
                        'auth-form',
                        authTab === 'register' && 'active',
                    )}
                >
                    <div className="form-group">
                        <label className="form-label">Hero Name</label>
                        <input
                            type="text"
                            className="form-input"
                            placeholder="e.g. ShadowWalker"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label">Email Address</label>
                        <input
                            type="email"
                            className="form-input"
                            placeholder="hero@levelup.com"
                        />
                    </div>
                    <div className="form-group">
                        <label className="form-label">Password</label>
                        <input
                            type="password"
                            className="form-input"
                            placeholder="••••••••"
                        />
                    </div>
                    <button className="btn btn-primary" onClick={onLogin}>
                        Create Account
                    </button>
                </div>
            </div>
        </div>
    );
}
