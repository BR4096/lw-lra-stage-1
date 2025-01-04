import React, { useState, useEffect } from 'react';

const AssessmentSlider = ({ value, onChange, min = 0, max = 100, step = 5 }) => {
  const [currentValue, setCurrentValue] = useState(value || min);
  const [isDragging, setIsDragging] = useState(false);

  useEffect(() => {
    if (value !== currentValue) {
      setCurrentValue(value);
    }
  }, [value]);

  const handleChange = (e) => {
    const newValue = Math.round(Number(e.target.value) / step) * step;
    setCurrentValue(newValue);
    onChange(newValue);
  };

  const getBackgroundSize = () => {
    return {
      backgroundSize: `${((currentValue - min) * 100) / (max - min)}% 100%`
    };
  };

  return (
    <div className="flex flex-col items-center w-full max-w-md mx-auto my-4">
      <div className="text-2xl font-semibold text-blue-600 mb-2">
        {currentValue}
      </div>
      <div className="relative w-full h-12">
        <input
          type="range"
          min={min}
          max={max}
          step={step}
          value={currentValue}
          onChange={handleChange}
          onMouseDown={() => setIsDragging(true)}
          onMouseUp={() => setIsDragging(false)}
          onTouchStart={() => setIsDragging(true)}
          onTouchEnd={() => setIsDragging(false)}
          className="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer
                     [&::-webkit-slider-thumb]:appearance-none
                     [&::-webkit-slider-thumb]:w-6
                     [&::-webkit-slider-thumb]:h-6
                     [&::-webkit-slider-thumb]:rounded-full
                     [&::-webkit-slider-thumb]:bg-blue-600
                     [&::-webkit-slider-thumb]:cursor-pointer
                     [&::-webkit-slider-thumb]:transition-all
                     [&::-webkit-slider-thumb]:duration-150
                     [&::-webkit-slider-thumb]:ease-in-out
                     [&::-webkit-slider-thumb]:hover:bg-blue-700
                     [&::-webkit-slider-thumb]:active:scale-110
                     [&::-moz-range-thumb]:w-6
                     [&::-moz-range-thumb]:h-6
                     [&::-moz-range-thumb]:rounded-full
                     [&::-moz-range-thumb]:bg-blue-600
                     [&::-moz-range-thumb]:border-0
                     [&::-moz-range-thumb]:cursor-pointer
                     [&::-moz-range-thumb]:transition-all
                     [&::-moz-range-thumb]:duration-150
                     [&::-moz-range-thumb]:ease-in-out
                     [&::-moz-range-thumb]:hover:bg-blue-700
                     [&::-moz-range-thumb]:active:scale-110"
          style={getBackgroundSize()}
        />
      </div>
      <div className="w-full flex justify-between text-sm text-gray-500 mt-1">
        <span>{min}</span>
        <span>{max}</span>
      </div>
    </div>
  );
};

export default AssessmentSlider;