// intervals
function centralizedInterval(intervalCallback, time = 4800) {
  // let interval = setInterval(() => moveHeroSlider(), 4800);
  let interval = setInterval(intervalCallback, time);

  const getInterval = () => interval;
  const changeIntervalValue = (intervalParam) => interval = intervalParam;
  const clearInternalInterval = () => clearTimeout(interval);

  return { getInterval, changeIntervalValue, clearInternalInterval };
}

export default centralizedInterval;