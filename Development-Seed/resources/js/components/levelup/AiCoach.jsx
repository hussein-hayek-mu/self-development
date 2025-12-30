import { classNames } from './classNames';

export function AiCoach({ activePage, chatMessages, onSendChatMessage }) {
    return (
        <div
            className={classNames('page', activePage === 'ai' && 'active')}
            id="page-ai"
        >
            <h1 className="section-header" style={{ marginBottom: '2rem' }}>
                AI Coach
            </h1>
            <div className="chat-window">
                <div className="chat-messages" id="chatMessages">
                    {chatMessages.map((msg, idx) => (
                        <div key={idx} className="chat-message">
                            <strong>{msg.from}:</strong> {msg.text}
                        </div>
                    ))}
                </div>
                <div className="chat-input-area">
                    <div
                        className="chat-suggestions"
                        style={{
                            display: 'flex',
                            gap: '0.5rem',
                            flexWrap: 'wrap',
                        }}
                    >
                        <button
                            className="btn btn-secondary btn-small"
                            onClick={() => onSendChatMessage('Help me focus')}
                        >
                            Focus Task
                        </button>
                        <button
                            className="btn btn-secondary btn-small"
                            onClick={() =>
                                onSendChatMessage('I need motivation')
                            }
                        >
                            Motivation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
}
