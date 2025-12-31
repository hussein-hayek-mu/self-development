import { classNames } from './classNames';

export function QuestModal({
    show,
    form,
    onChange,
    onSave,
    onDelete,
    onClose,
}) {
    return (
        <div
            className={classNames('modal-overlay', show && 'active')}
            id="questModal"
        >
            <div className="modal-content">
                <h2
                    id="questModalTitle"
                    className="section-header"
                    style={{ marginBottom: '1.5rem', fontSize: '1.5rem' }}
                >
                    {form.id ? 'Edit Quest' : 'Add New Quest'}
                </h2>
                <input
                    type="hidden"
                    id="questId"
                    value={form.id ?? ''}
                    readOnly
                />
                <input
                    type="hidden"
                    id="questOriginalType"
                    value={form.originalType}
                    readOnly
                />
                <div className="form-group">
                    <label className="form-label">Quest Type</label>
                    <select
                        id="questType"
                        className="form-input"
                        value={form.type}
                        onChange={(e) =>
                            onChange((f) => ({
                                ...f,
                                type: e.target.value,
                            }))
                        }
                    >
                        <option value="daily">Daily Quest</option>
                        <option value="weekly">Weekly Quest</option>
                        <option value="boss">Boss Quest</option>
                    </select>
                </div>
                <div className="form-group">
                    <label className="form-label">Quest Title</label>
                    <input
                        type="text"
                        id="questTitle"
                        className="form-input"
                        placeholder="e.g. Finish Report"
                        value={form.title}
                        onChange={(e) =>
                            onChange((f) => ({ ...f, title: e.target.value }))
                        }
                    />
                </div>
                <div className="form-group">
                    <label className="form-label">XP Reward</label>
                    <input
                        type="number"
                        id="questXp"
                        className="form-input"
                        placeholder="e.g. 100"
                        value={form.xp}
                        onChange={(e) =>
                            onChange((f) => ({
                                ...f,
                                xp: Number(e.target.value),
                            }))
                        }
                    />
                </div>
                <div className="form-group">
                    <label className="form-label">Time / Deadline</label>
                    <input
                        type="text"
                        id="questTime"
                        className="form-input"
                        placeholder="e.g. 30 min"
                        value={form.time}
                        onChange={(e) =>
                            onChange((f) => ({ ...f, time: e.target.value }))
                        }
                    />
                </div>
                <div className="form-group">
                    <label className="form-label">Difficulty</label>
                    <select
                        id="questDifficulty"
                        className="form-input"
                        value={form.difficulty}
                        onChange={(e) =>
                            onChange((f) => ({
                                ...f,
                                difficulty: e.target.value,
                            }))
                        }
                    >
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
                <div
                    style={{
                        display: 'flex',
                        gap: '1rem',
                        justifyContent: 'flex-end',
                    }}
                >
                    <button
                        className="btn btn-secondary btn-small"
                        onClick={onClose}
                    >
                        Cancel
                    </button>
                    {form.id && (
                        <button
                            className="btn btn-danger btn-small"
                            onClick={onDelete}
                        >
                            Delete
                        </button>
                    )}
                    <button
                        className="btn btn-primary btn-small"
                        onClick={onSave}
                    >
                        Save Quest
                    </button>
                </div>
            </div>
        </div>
    );
}
