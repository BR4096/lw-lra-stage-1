import React, { useState } from 'react';
import AssessmentQuestion from '../components/AssessmentQuestion';
import '../styles/assessment.css';

const AssessmentPage = () => {
  const [answers, setAnswers] = useState({
    decisionEffectiveness: 50,
    teamAutonomy: 50,
    leadershipSuccess: 50,
    readyLeaders: 0,
    dependencies: 0
  });

  const handleAnswer = (field, value) => {
    setAnswers(prev => ({
      ...prev,
      [field]: value
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    // Handle form submission
    console.log('Answers:', answers);
  };

  return (
    <div className="assessment-container">
      <form onSubmit={handleSubmit}>
        <AssessmentQuestion
          question="How would you rate your organization's decision-making effectiveness?"
          description="Consider factors like speed, clarity, and outcome quality"
          value={answers.decisionEffectiveness}
          onChange={(value) => handleAnswer('decisionEffectiveness', value)}
        />

        <AssessmentQuestion
          question="What level of autonomy do your teams have?"
          description="Evaluate their ability to make independent decisions"
          value={answers.teamAutonomy}
          onChange={(value) => handleAnswer('teamAutonomy', value)}
        />

        <AssessmentQuestion
          question="How successful are your current leadership initiatives?"
          description="Consider achievement of leadership development goals"
          value={answers.leadershipSuccess}
          onChange={(value) => handleAnswer('leadershipSuccess', value)}
        />

        <AssessmentQuestion
          question="How many leaders are ready for the next level?"
          description="Count of leaders prepared for promotion"
          value={answers.readyLeaders}
          onChange={(value) => handleAnswer('readyLeaders', value)}
          type="number"
        />

        <AssessmentQuestion
          question="How many critical dependencies exist in your organization?"
          description="Count of key person dependencies"
          value={answers.dependencies}
          onChange={(value) => handleAnswer('dependencies', value)}
          type="number"
        />

        <div className="navigation-buttons">
          <button type="button" className="nav-button previous">
            Previous
          </button>
          <button type="submit" className="nav-button next">
            Next
          </button>
        </div>
      </form>
    </div>
  );
};

export default AssessmentPage;