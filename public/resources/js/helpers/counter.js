function iCounter() {
  let i = 0;

  const decrementCounter = () => (i > 0) ? i -= 1 : 0;
  const incrementCounter = () => i += 1;
  const setCounter = (num) => i = num;
  const getCounter = () => i;

  return { incrementCounter, decrementCounter, setCounter, getCounter };
}

export default iCounter;