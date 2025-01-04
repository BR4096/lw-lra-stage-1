import React from 'react';
import AssessmentSlider from './AssessmentSlider';

const AssessmentQuestion = ({ 
  question,
  description,
  value,
  onChange,
  type = 'slider'
}) => {
  return (
    <div className="question-card">
      <h3 className="question-title">{question}</h3>
      {description && (
        <p className="question-description">{description}</p>
      )}
      {type === 'slider' ? (
        <AssessmentSlider
          value={value}
          onChange={onChange}
          min={0}
          max={100}
          step={5}
        />
      ) : (
        <input
          type="number"
          value={value}
          onChange={(e) => onChange(Number(e.target.value))}
          className="input-field"
          min={0}
          step={1}
        />
      )}
    </div>
  );
};

export default AssessmentQuestion;