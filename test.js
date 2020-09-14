const arr = [12, 'let', 'const', 20];

const filter = arr.filter(filterType);

function filterType(item) {
  return typeof item === 'string';
}

console.log(filter);
