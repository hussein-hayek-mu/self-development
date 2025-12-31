import { classNames } from './classNames';

export function HabitModal({
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
            id="habitModal"
        >
            <div className="modal-content">
                <h2
                    id="habitModalTitle"
                    className="section-header"
                    style={{ marginBottom: '1.5rem', fontSize: '1.5rem' }}
                >
                    {form.id ? 'Edit Habit' : 'Add New Habit'}
                </h2>
                <input
                    type="hidden"
                    id="habitId"
                    value={form.id ?? ''}
                    readOnly
                />
                <div className="form-group">
                    <label className="form-label">Habit Title</label>
                    <input
                        type="text"
                        id="habitTitle"
                        className="form-input"
                        placeholder="e.g. Morning Jog"
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
                        id="habitXp"
                        className="form-input"
                        placeholder="e.g. 50"
                        value={form.xp}
                        onChange={(e) =>
                            onChange((f) => ({
                                ...f,
                                xp: Number(e.target.value),
                            }))
                        }
                    />
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
                        Save Habit
                    </button>
                </div>
            </div>
        </div>
    );
}
